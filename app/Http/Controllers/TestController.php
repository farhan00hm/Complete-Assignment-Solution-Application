<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\User;
use App\Models\Expert;
use App\Models\Subject;
use App\Models\Homework;

use DB;
use PDF;

use App\Exports\UserPaymentsExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Traits\TransactionTrait;

use App\Jobs\WeeklyPayment;
use App\Jobs\WeeklyPaymentReceipt;
use App\Models\Transaction;
use App\Models\WeeklyPayment as WeeklyPaymentModel;

class TestController extends Controller {
    use TransactionTrait;

    public function test(){
        /*$roles = ['SubD', 'SubCS', 'SubP', 'SubAuth', 'SubSys'];

        for ($i=0; $i < sizeof($roles); $i++) {
            $role = Role::where('name', $roles[$i])->delete();
        }

        for ($i=0; $i < sizeof($roles); $i++) {
            $role = Role::where('name', $roles[$i])->first();

            if (! $role) {
                Role::create([
                    'name' => $roles[$i],
                    'long_name' => $this->getLong($roles[$i]),
                    'description' => $this->getDesc($roles[$i]),
                ]);
            }
        }*/

    	/*Role::where('name', 'XE')->update([
    		'name' => 'FL'
    	]);

    	User::where('user_type', 'XE')->update([
    		'user_type' => 'FL'
    	]);*/

        //return Excel::download(new UserPaymentsExport(), 'payments.xlsx');

        /*DB::beginTransaction();

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

        // Add a weely payment DB entry
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

        // Send an email to expert with link to invoice
        foreach ($experts as $expert) {
            try {
                $name = $expert->first_name." ".$expert->last_name;
                $link = url('/freelancers/payment-receipts/'.$trx->uuid."?uuid=".$expert->uuid);
                WeeklyPaymentReceipt::dispatch($expert->email, $link, $name);
            } catch (Exception $e) {
                \Log::error($e);
            }
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

        DB::commit();*/
        $hw = Homework::where('id', 1004)->first();
        $subs = Subject::where('sub_category_id', '=', 1003)->get();

        foreach ($subs as $sub) {
            echo $sub->expert->user->email."<br>";
            echo $hw->uuid."<br>";
            echo $hw->title."<br>";

            echo "<br><br>";
        }
    	/*return view('emails.student-homework-approved', [
    		'title' => 'System Access credentials',
            'subject' => 'System Access credentials',
            'name' => 'Benjamin Munyoki',
            'email' => 'email@email.com',
            'link' => 'sdsdsdsdsd',
            'role' => 'Customer Service'
    	]);*/

    }

    public function getLong($name){
        if ($name == "SubD") {
            return "Dispute management";
        }

        if ($name == "SubCS") {
            return "Customer service";
        }

        if ($name == "SubP") {
            return "Payroll Download";
        }

        if ($name == "SubAuth") {
            return "Freelancer profile authentication";
        }

        if ($name == "SubSys") {
            return "System Admin";
        }

        return "System Admin";
    }

    public function getDesc($name){
        if ($name == "SubD") {
            return "Dispute management";
        }

        if ($name == "SubCS") {
            return "Customer service - chat and contact us";
        }

        if ($name == "SubP") {
            return "Payroll Download - payments and refunds";
        }

        if ($name == "SubAuth") {
            return "Freelancer profile authentication - approve, decline, block freelancers";
        }

        if ($name == "SubSys") {
            return "System Admin";
        }

        return "System Admin";
    }
}
