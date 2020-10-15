<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\User;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if(User::where('user_type', "Admin")->count() == 0){
        	User::insert([
        		[
        			'first_name' => 'Bemi',
        			'last_name' => 'Barin',
        			'username' => 'admin',
        			'email' => 'admin@email.com',
        			'user_type' => "Admin",
        			'email_verified_at' => Carbon\Carbon::now()->toDateString(),
        			'password' => Hash::make('Admin123'),
        			'uuid' => (string) Str::uuid(),
        			'created_at' => Carbon\Carbon::now()->toDateString(),
        			'updated_at' => Carbon\Carbon::now()->toDateString()
        		]
        	]);

        	// Attach role to user
        	$user = User::where('user_type', "Admin")->first();
        	$user->assignRole('Admin');
        }
    }
}
