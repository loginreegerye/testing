<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')
    		->where('id', 1)
    		->update([
    					'first_name' => 'admin',
    					'last_name' => 'admin',
    					'email' => 'admin@email.domain',
    					'password' => Hash::make('12345678'),
    					'role' => 'admin'
    				]);
    }
}
