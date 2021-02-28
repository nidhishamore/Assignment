<?php

namespace App\Services;

use App\Helpers\ModelIncremental;
use Exception;
use App\Model\Admin;
use App\Model\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
	public function registerAdmin($data)
	{
		$admin = Admin::where('email', $data['email'])->where('status', 1)->first();

        if (!empty($admin)) {
            throw new Exception('You are already registered. Please log in.', 400);
        }
		Admin::create([
            'admin_id' => ModelIncremental::generateIncrementId('admin'),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => 1
        ]);
	}

	public function getAdminByEmail($email)
	{
		return Admin::where('email', $email)->firstOrFail();
	}

	public function storeAdminToken($token)
	{
		$admin = Auth::guard('admin')->user();
		$admin->remember_token = $token;
		$admin->save();
	}

	public function registerUser($data)
	{
		$user = Customer::where('email', $data['email'])->where('status', 1)->first();

        if (!empty($user)) {
            throw new Exception('You are already registered. Please log in.', 400);
        }

        $create = [
            'customer_id' => ModelIncremental::generateIncrementId('customer'),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'], 
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'password' => $data['password'],
            'status' => 1,
        ];
		Customer::create($create);
	}

	public function getUserByEmail($email)
	{
		return Customer::where('email', $email)->firstOrFail();
	}

	public function storeUserToken($token)
	{
		$user = Auth::guard('user')->user();
		$user->remember_token = $token;
		$user->save();
	}
}