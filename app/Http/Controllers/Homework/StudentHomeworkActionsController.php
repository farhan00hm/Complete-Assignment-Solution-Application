<?php

namespace App\Http\Controllers\Homework;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Traits\TransactionTrait;
use App\Jobs\StudentHomeworkSolutionApproved;
use App\Jobs\SEHomeworkSolutionApproved;
use App\Jobs\RequestRevision;


use Carbon\Carbon;

use App\Models\Homework;
use App\Models\Transaction;
use App\Models\Commission;

class StudentHomeworkActionsController extends Controller {
	use TransactionTrait;

     
    /**
     * Get completed homeworks - can be approved or pending student approval
     * @return \Illuminate\View\View
    */
    public function completed(Request $request){

        

    	$hws = Homework::where('posted_by', auth()->user()->id)->where('status', 6)->orderBy('id', 'DESC')->paginate(10);

            // @dd($hws[0]->created_at);
            // @dd($hws[0]->solution->created_at->addDays(4));
       
          // $dt = Carbon::parse($hws[0]->solution->created_at);
          // @dd($dt->day);

             // $interval = Carbon::parse($hws[0]->solution->created_at->addDays(3));
          // @dd($interval->day);
            

   		if (! empty($request->status)) {
   			$status = $request->status;

             //                              if($hw->status === 6 && $interval > $hw->solution->created_at)
             //                              {
             //                                 return $hw->status == 8;
             //                              }

   			if ($status === "approved"  ) {
   				$hws = Homework::where('posted_by', auth()->user()->id)->where('status', 8)->orderBy('id', 'DESC')->paginate(10);
               
            
   			}

        

   			if ($status === "pending") {
   				$hws = Homework::where('posted_by', auth()->user()->id)->where('status', 6)->orderBy('id', 'DESC')->paginate(10);
   			}

           
   		}
         
               

        return view('member/homework/student/completed', [
            'title' => 'Completed Homeworks',
            'hws' => $hws,
            'link' => 'hwks',
        ]);

        // $hws = Homework::first();

        //     $hws->rate(3);
            // dd(Homework::first()->ratings); 
            // dd($hws->averageRating); //show avg rateing
    }

    /**
     * Student approve homework solution
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function approveSolution(Request $request) {
    	$validator = \Validator::make($request->all(), [
			'uuid' => 'required|string',

        ]);

        // $hws = Homework::where('posted_by', auth()->user()->id)->where('status', 6)->orderBy('id', 'DESC')->paginate(10);

           
            // @dd($hws[0]->created_at);
            // @dd($hws[0]->solution->created_at->addDays(4));
       
          // $dt = Carbon::parse($hws[0]->solution->created_at);
        // $dt = Carbon::now();
        // @dd($dt->day);

             // $interval = Carbon::parse($hws[0]->solution->created_at->addDays(3));
          // @dd($interval->day);

            // @dd($request->created_at);

        if ($validator->passes() ) {
        	$hw = Homework::where('uuid', $request->uuid)->first();

        	if (! $hw) {
        		return response()->json([
	                'success' => 0,
	                'error' => 'Invalid homework'
	            ], 200);
        	}

        	DB::beginTransaction();
            // Update homework set status = 8 (student approved solution)
            try {
                $hw->update([
                    'status' => 8,
                ]);

            } catch (\Exception $e) {
                \Log::error($e);
                return response()->json([
                    'success' => 0,
                    'error' => 'Error updating homework. Error: '. $e->getMessage(),
                ], 200);
            }

            // Update homework solutions table set status = 2 (accepted)
            try {
                $hw->solution->update([
                    'status' => 2,
                ]);

            } catch (\Exception $e) {
                \Log::error($e);
                return response()->json([
                    'success' => 0,
                    'error' => 'Error updating homework solution. Error: '. $e->getMessage(),
                ], 200);
            }


            // Update escrow set status = MATURED
            try {
                $hw->escrow->update([
                    'status' => 'MATURED',
                    'maturity_date' => date('Y-m-d'),
                    'comments' => 'Escrow amount release by student on solution approval',
                ]);

            } catch (\Exception $e) {
                \Log::error($e);
                return response()->json([
                    'success' => 0,
                    'error' => 'Error updating homework solution. Error: '. $e->getMessage(),
                ], 200);
            }

            // Create a transaction entry (to pay solution expert)
            try {
                $trx = new Transaction;
                $trx->from_user = auth()->user()->id;
                $trx->to_user = $hw->awarded_to;
                $trx->initiator = auth()->user()->id;
                $trx->sk_ref = $this->generateSkooliTransactionRef();
                $trx->amount =  ($hw->escrow->amount - (0.25 * $hw->escrow->amount));
                $trx->status = "COMPLETED";
                $trx->type = "PAY";
                $trx->processor = "INTERNAL";
                $trx->processor_status = "SUCCESS";
                $trx->comments = "Homework solution approved.";
                $trx->save();

            } catch (\Exception $e) {
                \Log::error($e);
               return response()->json([
                    'success' => 0,
                    'error' => 'Error creating a transaction. Error: '. $e->getMessage(),
                ], 200);
            }

            // Create an entry for commissions (25% of the escrow amount)
            try {
                $comm = new Commission;
                $comm->homework_id = $hw->id;
                $comm->escrow_id = $hw->escrow->id;
                $comm->amount = (0.25 * $hw->escrow->amount);
                $comm->save();

            } catch (\Exception $e) {
                \Log::error($e);
                return response()->json([
                    'success' => 0,
                    'error' => 'Error deducting commission. Error: '. $e->getMessage(),
                ], 200);
            }

            // Top up wallet for the FL (less 25% commission)
            try {
                $hw->awardedTo->update([
                    'wallet' => ($hw->awardedTo->wallet + ($hw->escrow->amount - (0.25 * $hw->escrow->amount))),
                ]);

            } catch (\Exception $e) {
                \Log::error($e);
                return response()->json([
                    'success' => 0,
                    'error' => 'Error updating solution expert wallet. Error: '. $e->getMessage(),
                ], 200);
            }

            DB::commit();

            // Sent an email to the FL alerting them that homework has been accepted and they have been paid
            SEHomeworkSolutionApproved::dispatch($hw->awardedTo->email, $hw->uuid);

            // Sent an email to the student informing them that they have accepted the homework solution
            StudentHomeworkSolutionApproved::dispatch(auth()->user()->email, $hw->uuid);

        	return response()->json([
                'success' => 1,
                'message' => 'Homework solution approved.'
            ], 201);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }
    

    /**
     * Student request revision
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function requestRevision(Request $request) {
        $validator = \Validator::make($request->all(), [
            'uuid' => 'required|string',
            'note' => 'required',
            'percentage' => 'required|numeric'

        ]);

        if ($validator->passes()) {
            $hw = Homework::where('uuid', $request->uuid)->first();
            $note = $request->get('note');
            $percentage = $request->get('percentage');

            if (! $hw) {
                return response()->json([
                    'success' => 0,
                    'error' => 'Invalid homework'
                ], 200);
            }

            DB::beginTransaction();

            // Update homework solutions table set status = 6 (Revision requested)
            try {
                $hw->solution->update([
                    'status' => 6,
                ]);

            } catch (\Exception $e) {
                \Log::error($e);
                return response()->json([
                    'success' => 0,
                    'error' => 'Error updating homework solution. Error: '. $e->getMessage(),
                ], 200);
            }

            DB::commit();

            // Sent an email to the FL alerting them that homework revision has been requested
            RequestRevision::dispatch($hw->awardedTo->email, $hw->uuid,$note,$percentage);

            return response()->json([
                'success' => 1,
                'message' => 'Homework solution revision has been requested.'
            ], 201);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }



}
