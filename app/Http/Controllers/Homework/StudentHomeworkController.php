<?php

namespace App\Http\Controllers\Homework;

use App\Http\Controllers\Controller;
use App\Notifications\NewHomeworkNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Jobs\NewHomework;

use App\Models\Homework;
use App\Models\HomeworkFile;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Subject;
use App\Models\Transaction;
use App\Traits\TransactionTrait;
use App\User;

class StudentHomeworkController extends Controller {

   use TransactionTrait;

    /**
     * Get student select homework category page
     * @return \Illuminate\View\View
    */
    public function index(Request $request){
    	$cats = Category::all();
    	$subCats = SubCategory::all();
    	return view('member/homework/student/new', [
    		'title' => 'Post Homework - Select Homework Category',
    		'cats' => $cats,
    		'subCats' => $subCats,
    		'link' => 'hwks',
    	]);

    }

    /**
     * Create a homework entry
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function create(Request $request) {
    	$validator = \Validator::make($request->all(), [
			'title' => 'required|string',
            'category' => 'required|string',
            'budget' => 'required|numeric',
            'deadline' => 'required|date',
            'description' => 'required|string',
            'files.*' => 'nullable|max:2048'
        ]);

        if ($validator->passes()) {
        	$date = Carbon::parse($request->input('deadline'));
	    	$now = Carbon::now();

			$diff = $date->diffInDays($now, false);
			if ($diff >= 0) {
				return back()->with('error', 'The deadline must be atleast a day from today')->withInput($request->input());
			}

        	DB::beginTransaction();
        	// Create a homework
	        try {
	        	$hw = new Homework;
	            $hw->posted_by = auth()->user()->id;
	            $hw->sub_category_id = $request->input('category');
	            $hw->title = ucwords($request->input('title'));
	            $hw->description = $request->input('description');
	            $hw->deadline = $request->input('deadline');
	            $hw->budget = $request->input('budget');
	            $hw->save();

	        } catch (\Exception $e) {
	        	\Log::error($e);
	            return back()->with('errors', $e->getMessage())->withInput($request->input());
	        }

	        if($request->hasfile('files')) {
	            foreach($request->file('files') as $file) {
	            	try {
			            $name = time().$file->getClientOriginalName();

			            $uploaded = Storage::disk('s3')->put($name, file_get_contents($file), 'public');
			        } catch (\Exception $e) {
			        	\Log::error($e);
			            return back()->with('errors', $e->getMessage())->withInput($request->input());
			        }

		            if ($uploaded == 1) {
		            	$upload_path = "https://skooli-uploads.s3.amazonaws.com/".str_replace(' ', '+', $name);

		            	try {
				        	$hwf = new HomeworkFile;
				            $hwf->homework_id = $hw->id;
				            $hwf->upload_path = $upload_path;
				            $hwf->save();

				        } catch (\Exception $e) {
				        	\Log::error($e);
				            return back()->with('errors', $e->getMessage())->withInput($request->input());
				        }
		            }
	            }
	        }

	        DB::commit();

	        // Queue an email to all solutions experts who have the selected category
            $subs = Subject::where('sub_category_id', $hw->sub_category_id)->get();
            foreach ($subs as $sub) {
                $name = @$sub->expert->user->first_name." ".$sub->expert->user->last_name;
                $user = User::find(@$sub->expert->user->id);
                $user->notify(new NewHomeworkNotification($hw->uuid,$hw->title));
//                Notification::send($user,new NewHomeworkNotification($hw->uuid,$hw->title));
                NewHomework::dispatch($sub->expert->user->email, $name, $hw->uuid, $hw->title);

            }

	        return redirect('/homeworks/open')->with('success', 'Your homework has been posted. Bids are on the way');
        }

        return back()->with('errors', $validator->errors()->all())->withInput($request->input());
    }

    /**
     * Get edit homework page
     * @return \Illuminate\View\View
    */
    public function edit(Request $request){
        $hw = Homework::where('uuid', $request->segment(3))->first();

        if (!$hw) {
            abort(404);
        }

        if ($hw->status != 1) {
            return redirect()->back();
        }

        $cats = Category::all();
        $subCats = SubCategory::all();

        return view('member/homework/student/edit', [
            'title' => 'Edit Homeworks',
            'hw' => $hw,
            'cats' => $cats,
            'subCats' => $subCats,
            'link' => 'hwks',
        ]);

    }

    /**
     * Update a homework
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request) {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string',
            'budget' => 'required|numeric',
            'deadline' => 'required|date',
            'description' => 'required|string',
            'files.*' => 'nullable|max:2048'
        ]);

        if ($validator->passes()) {
            $date = Carbon::parse($request->input('deadline'));
            $now = Carbon::now();

            $diff = $date->diffInDays($now, false);
            if ($diff >= 0) {
                return back()->with('error', 'The deadline must be atleast a day from today')->withInput($request->input());
            }

            DB::beginTransaction();
            // Update homework
            try {
                $hw = Homework::where('id', $request->input('id'))->first();
                $hw->update([
                    'sub_category_id' => $request->input('sub'),
                    'title' => ucwords($request->input('title')),
                    'description' => $request->input('description'),
                    'deadline' => $request->input('deadline'),
                    'budget' => $request->input('budget'),
                ]);

            } catch (\Exception $e) {
                \Log::error($e);
                return back()->with('errors', $e->getMessage())->withInput($request->input());
            }

            if($request->hasfile('files')) {
                foreach($request->file('files') as $file) {
                    try {
                        $name = time().$file->getClientOriginalName();

                        $uploaded = Storage::disk('s3')->put($name, file_get_contents($file), 'public');
                    } catch (\Exception $e) {
                        \Log::error($e);
                        return back()->with('errors', $e->getMessage())->withInput($request->input());
                    }

                    if ($uploaded == 1) {
                        $upload_path = "https://skooli-uploads.s3.amazonaws.com/".str_replace(' ', '+', $name);

                        try {
                            $hwf = new HomeworkFile;
                            $hwf->homework_id = $hw->id;
                            $hwf->upload_path = $upload_path;
                            $hwf->save();

                        } catch (\Exception $e) {
                            \Log::error($e);
                            return back()->with('errors', $e->getMessage())->withInput($request->input());
                        }
                    }
                }
            }

            DB::commit();

            return redirect('/homeworks/open')->with('success', 'Your homework has been updated.');
        }

        return back()->with('errors', $validator->errors()->all())->withInput($request->input());
    }

    /**
     * Get open homeworks - receiving bids
     * @return \Illuminate\View\View
    */
    public function open(Request $request){
    	$hws = Homework::where('posted_by', auth()->user()->id)->where('status', 1)->orderBy('id', 'DESC')->paginate(10);

    	return view('member/homework/student/open', [
    		'title' => 'Open Homeworks',
    		'hws' => $hws,
    		'link' => 'hwks',
    	]);

    }

    /**
     * Get ongoing homeworks - already hired
     * @return \Illuminate\View\View
    */
    public function ongoing(Request $request){
        $hws = Homework::where('posted_by', auth()->user()->id)->whereIn('status', [3, 5])->orderBy('id', 'DESC')->paginate(10);
        
        return view('member/homework/student/ongoing', [
            'title' => 'Ongoing Homeworks',
            'hws' => $hws,
            'link' => 'hwks',
        ]);

    }

    /**
     * Get bids for a particular homework
     * @return \Illuminate\View\View
    */
    public function bids(Request $request){
    	$hw = Homework::where('uuid', $request->segment(2))->orderBy('id', 'DESC')->first();

    	return view('member/homework/student/bids', [
    		'title' => 'Bids',
    		'hw' => $hw,
    		'link' => 'hwks',
    	]);

    }

    /**
     * Delete a homework
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function delete(Request $request){
   
        if (Homework::where('uuid', $request->input('uuid'))->delete()) {
       

                 $homework = Homework::where('uuid', $request->input('uuid'))->withTrashed()->first();
           // @dd($homework);
               
          
          DB::beginTransaction();
                 


                     // Update homeworks table set: status = 10(student delete homework and refund to user)
                    try {
                        $homework->update([
                            'status' => 10,
                        ]);                    
                    } catch (\Exception $e) {
                        \Log::error($e);
                        return response()->json(['error', $e->getMessage()]);
                    }                   
                      
                     // Update users table (wallet field) : refund
                    try {
                        $homework->postedBy->update([
                            'wallet' => ($homework->postedBy->wallet + $homework->winningBid->amount),
                        ]);                   
                     } catch (\Exception $e) {
                        \Log::error($e);
                        return response()->json(['error', $e->getMessage()]);
                    }                    

                    // Create a transaction entry
                    try {
                        $trx = new Transaction;
                        $trx->from_user = $homework->awardedTo->id;
                        $trx->to_user = $homework->postedBy->id;
                        $trx->initiator = $homework->awardedTo->id;
                        $trx->homework_id = $homework->id;
                        $trx->sk_ref = $this->generateSkooliTransactionRef();
                        $trx->amount = $homework->winningBid->amount;
                        $trx->status = "COMPLETED";
                        $trx->type = "PAY";
                        $trx->processor = "INTERNAL";
                        $trx->processor_status = "SUCCESS";
                        $trx->comments = "Refund user for delete homework ";
                        $trx->save();                    
                    } catch (\Exception $e) {
                        \Log::error($e);
                        return response()->json(['error', $e->getMessage()]);
                    }                    

                    // Update escrow set status = MATURED
                    try {
                        $homework->escrow->update([
                            'status' => 'MATURED',
                            'maturity_date' => date('Y-m-d'),
                            'comments' => 'Escrow amount release for refunding student As Student delete homework',
                        ]);                    
                    } catch (\Exception $e) {
                        \Log::error($e);
                        return response()->json([
                            'success' => 0,
                            'error' => 'Error updating homework solution. Error: '. $e->getMessage(),
                        ], 200);
                    }

              DB::commit();

    



      return response()->json([
                'success' => 1,
                'message' => 'Homework has been deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'error' => 'Error deleting homework'
            ], 409);
        }
    }

    /**
     * Delete a homework file
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function deleteFile(Request $request){
        if (HomeworkFile::where('uuid', $request->input('uuid'))->delete()) {
            return response()->json([
                'success' => 1,
                'message' => 'File deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'error' => 'Error deleting file'
            ], 409);
        }
    }


    /**
     * Get archive homeworks - for Repost*
     * @return \Illuminate\View\View
     */
    public function archive(Request $request){
        $hws = Homework::where('posted_by', auth()->user()->id)->where('status', 2)->orderBy('id', 'DESC')->paginate(10);


        return view('member/homework/student/archive', [
            'title' => 'Archive Homeworks',
            'hws' => $hws,
            'link' => 'hwks',
        ]);

    }

     /**
     * Get canceled homeworks - for Repost*
     * @return \Illuminate\View\View
     */
    public function canceled(Request $request){
         $hws = Homework::onlyTrashed()->where('posted_by', auth()->user()->id)->where('status', 10)->orderBy('id', 'DESC')->paginate(10);
          // @dd($hws);

        return view('member/homework/student/canceled', [
            'title' => 'Canceled Homeworks',
            'hws' => $hws,
            'link' => 'hwks',
        ]);

    }

//    Edit the Archive homework when repost
    public function editArchiveHomework(Request $request){
//        dd($request->segment(3));
        $hw = Homework::where('uuid', $request->segment(4))->first();

        if (!$hw) {
            abort(404);
        }

        if ($hw->status != 2) {
            return redirect()->back();
        }

        $cats = Category::all();
        $subCats = SubCategory::all();

        return view('member/homework/student/archive-edit', [
            'title' => 'Edit Homeworks',
            'hw' => $hw,
            'cats' => $cats,
            'subCats' => $subCats,
            'link' => 'hwks',
        ]);

    }

//    Archive the update homework
    public function archiveHomeworkUpdate(Request $request) {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string',
            'budget' => 'required|numeric',
            'deadline' => 'required|date',
            'description' => 'required|string',
            'files.*' => 'nullable|max:2048'
        ]);

        if ($validator->passes()) {
            $date = Carbon::parse($request->input('deadline'));
            $now = Carbon::now();

            $diff = $date->diffInDays($now, false);
            if ($diff >= 0) {
                return back()->with('error', 'The deadline must be atleast a day from today')->withInput($request->input());
            }

            DB::beginTransaction();
            // Update homework
            try {
                $hw = Homework::where('id', $request->input('id'))->first();
                $hw->sub_category_id = $request->input('sub');
                $hw->title = $request->input('title');
                $hw->description = $request->input('description');
                $hw->deadline = $request->input('deadline');
                $hw->budget = $request->input('budget');
                $hw->created_at = Carbon::now();
                $hw->status = 1;
                $hw->save(['timestamps' => false]);

            } catch (\Exception $e) {
                \Log::error($e);
                return back()->with('errors', $e->getMessage())->withInput($request->input());
            }

            if($request->hasfile('files')) {
                foreach($request->file('files') as $file) {
                    try {
                        $name = time().$file->getClientOriginalName();

                        $uploaded = Storage::disk('s3')->put($name, file_get_contents($file), 'public');
                    } catch (\Exception $e) {
                        \Log::error($e);
                        return back()->with('errors', $e->getMessage())->withInput($request->input());
                    }

                    if ($uploaded == 1) {
                        $upload_path = "https://skooli-uploads.s3.amazonaws.com/".str_replace(' ', '+', $name);

                        try {
                            $hwf = new HomeworkFile;
                            $hwf->homework_id = $hw->id;
                            $hwf->upload_path = $upload_path;
                            $hwf->save();

                        } catch (\Exception $e) {
                            \Log::error($e);
                            return back()->with('errors', $e->getMessage())->withInput($request->input());
                        }
                    }
                }
            }

            DB::commit();

            return redirect('/homeworks/open')->with('success', 'Your homework has been updated.');
        }

        return back()->with('errors', $validator->errors()->all())->withInput($request->input());
    }

//    Repost the homewrok without changing any value
    public function repostHomework($id){
//        $hw = DB::table('homeworks')->where('uuid',$id)->first();
        $hw = Homework::where('uuid',$id)->first();

        if($hw->status == 2){
            try {
                $hw->status = 1;
                $hw->created_at = Carbon::now();
                $hw->save(['timestamps' => false]);
                return redirect('/homeworks/open')->with('success', 'Your homework has been Reposted.');
            } catch (\Exception $e) {
                \Log::error($e);
                return back()->with('errors', $e->getMessage());
            }
        }

    }

    public function refund_request(Request $request){
        
       if(Homework::where('uuid', $request->input('uuid'))){ 

            $homework = Homework::where('uuid', $request->input('uuid'))->first();
       // $hw = HomeworkSolution::where('uuid', $request->input('uuid')); 
           // @dd($hw->solution->refund);
           if($homework->solution->refund == 0){
            

                DB::beginTransaction();
                 


                     // Update homeworks table set: status = 11(student delete homework and refund to user)
                    try {
                        $homework->update([
                            'status' => 11,
                        ]);                    
                    } catch (\Exception $e) {
                        \Log::error($e);
                        return response()->json(['error', $e->getMessage()]);
                    }                   
                      
                     // Update users table (wallet field) : refund
                    try {
                        $homework->postedBy->update([
                            'wallet' => ($homework->postedBy->wallet + $homework->winningBid->amount),
                        ]);                   
                     } catch (\Exception $e) {
                        \Log::error($e);
                        return response()->json(['error', $e->getMessage()]);
                    }                    

                    // Create a transaction entry
                    try {
                        $trx = new Transaction;
                        $trx->from_user = $homework->awardedTo->id;
                        $trx->to_user = $homework->postedBy->id;
                        $trx->initiator = $homework->awardedTo->id;
                        $trx->homework_id = $homework->id;
                        $trx->sk_ref = $this->generateSkooliTransactionRef();
                        $trx->amount = $homework->winningBid->amount;
                        $trx->status = "COMPLETED";
                        $trx->type = "PAY";
                        $trx->processor = "INTERNAL";
                        $trx->processor_status = "SUCCESS";
                        $trx->comments = "Refund user for request-refund homework ";
                        $trx->save();                    
                    } catch (\Exception $e) {
                        \Log::error($e);
                        return response()->json(['error', $e->getMessage()]);
                    }                    

                    // Update escrow set status = MATURED
                    try {
                        $homework->escrow->update([
                            'status' => 'MATURED',
                            'maturity_date' => date('Y-m-d'),
                            'comments' => 'Escrow amount release for refunding student As Student request refund for homework',
                        ]);                    
                    } catch (\Exception $e) {
                        \Log::error($e);
                        return response()->json([
                            'success' => 0,
                            'error' => 'Error updating homework solution. Error: '. $e->getMessage(),
                        ], 200);
                    }

              DB::commit();

    



      return response()->json([
                'success' => 1,
                'message' => 'Homework has been deleted successfully'
            ], 200);
       }
     } else {
            return response()->json([
                'success' => 0,
                'error' => 'Error deleting homework'
            ], 409);
        }

     }


}
