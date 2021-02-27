<?php

use Illuminate\Database\Seeder;
use App\Model\Admin;
use App\Helpers\ModelIncremental;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
        	'admin_id' => ModelIncremental::generateIncrementId('admin'),
        	'name' => 'admin',
        	'email' => 'abc@example.com',
        	'password' => '123456',
        	'status' => 1
        ]);
    }
}
