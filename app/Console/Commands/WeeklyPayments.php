<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Exports\UserPaymentsExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Traits\TransactionTrait;

use DB;

use App\Jobs\WeeklyPayment;
use App\Jobs\WeeklyPaymentReceipt;
use App\Models\Transaction;
use App\User;
use App\Models\WeeklyPayment as WeeklyPaymentModel;

class WeeklyPayments extends Command {
    use TransactionTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates weekly excel file with freelancers payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        DB::beginTransaction();

        $initiator = User::whereHas("roles", function($q){ $q->where("name", "SubP"); })->first();
        // Pull and email excel file
        try {
            $fileName = date('Y-m-d')."_payments.xlsx";
            Excel::store(new UserPaymentsExport(), $fileName, 's3');
            $path = $fileName;

            WeeklyPayment::dispatch($initiator->email, $fileName, $path);
        } catch (Exception $e) {
            \Log::error($e);
        }

        $experts = User::where('user_type', 'FL')->where('wallet', '>=', 1000)->get();

        // Create transaction
        foreach ($experts as $expert) {
            try {
                $trx = new Transaction;
                $trx->from_user = $expert->id;
                $trx->to_user = $initiator->id;
                $trx->initiator = $initiator->id;
                $trx->sk_ref = $this->generateSkooliTransactionRef();
                $trx->amount = (float)$expert->wallet;
                $trx->status = "COMPLETED";
                $trx->type = "ADMIN WITHDRAW";
                $trx->processor = "INTERNAL";
                $trx->processor_status = "SUCCESS";
                $trx->comments = "Weekly payment";
                $trx->save();

            } catch (\Exception $e) {
                \Log::error($e);
            }
        }

        // Add a weekly payment DB entry
        try {
            $wpm = new WeeklyPaymentModel;
            $wpm->user_id = $initiator->id;
            $wpm->file_name = $fileName;
            $wpm->file_path = "https:/skooli-uploads.s3.amazonaws.com/".$fileName;
            $wpm->file_to_email = $initiator->email;
            $wpm->transaction_count = $experts->count();
            $wpm->transaction_total = $experts->sum('wallet');
            $wpm->save();

        } catch (\Exception $e) {
            \Log::error($e);
        }

        // Zerorize wallets
        foreach ($experts as $expert) {
            try {
                $expert->update([
                    'wallet' => 0.00
                ]);
            } catch (Exception $e) {
                \Log::error($e);
            }
        }

        DB::commit();
    }
}
