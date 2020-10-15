<?php

namespace App\Console\Commands;

use App\Models\Escrow;
use App\Models\Homework;
use App\Models\Transaction;
use App\Traits\TransactionTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RefundUserForMissingDeadlineBySECron extends Command
{
    use TransactionTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refundStudent:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refund to user if Freelancer Does not meet the deadline';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return JsonResponse
     */
    public function handle()
    {

        DB::beginTransaction();
        $homeworks = Homework::where('status', '5')->get();
        foreach ($homeworks as $homework) {
//            \Log::info($homework->winningBid()->first()->amount);

            if ($homework->winningBid) {
                $currentDarte = Carbon::parse(Carbon::now());
                $expected_completion_date = Carbon::parse($homework->winningBid->expected_completion_date);
                if ($expected_completion_date->diffInHours($currentDarte, false) >= 5) {
                    \Log::info('Bid id' . $homework->winningBid->id);
                    \Log::info('Todays Date' . Carbon::now());
                    \Log::info("Expected Completion Date: " . $homework->winningBid->expected_completion_date);
                    \Log::info("Time remaining: " . $expected_completion_date->diffInHours($currentDarte, false));
                    \Log::info("previous amount: ".$homework->postedBy->wallet." refund Amount:".$homework->winningBid->amount. " = ".($homework->postedBy->wallet + $homework->winningBid->amount));

                    // Update homeworks table set: status = 9(Expected Completion time expire and refund to user)
                    try {
                        $homework->update([
                            'status' => 9,
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
                        $trx->comments = "Refund user for expected completion time expire";
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
                            'comments' => 'Escrow amount release for refunding student As solution expert does not meet the expected completion deadline',
                        ]);

                    } catch (\Exception $e) {
                        \Log::error($e);
                        return response()->json([
                            'success' => 0,
                            'error' => 'Error updating homework solution. Error: '. $e->getMessage(),
                        ], 200);
                    }



//                    \Log::info('User:'.$homework->postedBy);
                }
//                \Log::info('Bid id'.$homework->winningBid->id);
//                \Log::info('Todays Date'.Carbon::now());
//                \Log::info("Expected Completion Date: ".$homework->winningBid->expected_completion_date);
//                \Log::info("Time remaining: ".$expected_completion_date->diffInHours($currentDarte,false));
            }
        }

        DB::commit();

    }
}
