<?php

namespace App\Services;

use App\Model\Product;
use App\Helpers\ModelIncremental;
use Exception;
use App\Model\Admin;
use Illuminate\Support\Facades\Hash;

class AuthService
{
	public function registerAdmin($data)
	{
		$admin = Admin::where('email', $data->email)->where('status', 1)->first();

        if (!empty($admin)) {
            throw new Exception('You are already registered. Please log in.', 400);
        }

		Admin::create([
            'admin_id' => ModelIncremental::generateIncrementId('admin'),
            'name' => $productData['name'],
            'email' => $productData['email'],
            'password' => $productData['password'],
            'status' => 1
        ]);
	}

	public function getAdminByEmail($email)
	{
		return Admin::where('email', $email)->firstOrFail();
	}

	public function loginAdmin($admin, $credentials)
	{
		return Hash::check($credentials['password'], $admin->password);
	}
}