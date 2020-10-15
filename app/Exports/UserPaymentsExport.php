<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;

use DB;

class UserPaymentsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){
        //return User::query()->select('first_name', 'last_name', 'username', 'email', 'phone', 'gender', 'dob', 'wallet')->where('user_type', 'FL')->get();

        /*return DB::select(DB::raw("SELECT users.first_name,  users.last_name,  users.username,  users.email,  users.phone,  users.gender,  users.dob,  users.wallet, experts.bank_name, experts.account_number  FROM users, experts WHERE experts.user_id = users.id AND users.user_type = 'FL' AND users.wallet >= 1000"));*/

        $experts = DB::table('users')
            ->join('experts', 'users.id', '=', 'experts.user_id')
            ->select('users.first_name', 'users.last_name', 'users.username', 'users.email', 'users.phone', 'users.gender', 'users.dob', 'users.wallet', 'experts.bank_name', 'experts.account_number')
            ->where('user_type', 'FL')
            ->where('wallet', '>=', 1000)
            ->get();

        return $experts;
    }

    public function map($experts): array {
        return [
            $experts->first_name,
            $experts->last_name,
            $experts->username,
            $experts->email,
            $experts->phone,
            $experts->gender,
            $experts->dob,
            $experts->wallet,
            $experts->bank_name,
            $experts->account_number,
        ];
    }

    public function headings(): array{
        return [
            'First Name',
            'Last Name',
            'Username',
            'Email',
            'Phone',
            'Gender',
            'DOB',
            'Balance (NGN)',
            'Bank Name',
            'Account Number'
        ];
    }
}

