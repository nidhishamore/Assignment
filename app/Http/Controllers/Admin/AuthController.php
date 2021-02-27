<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\AuthService;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->middleware('guest');
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
    	$request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:50|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);
    	DB::beginTransaction();
        try {
        	$this->authService->register($request->all());

        	DB::commit();

        	return redirect()->route('/admin/login')->with('success', 'You have been successfully registered. Please Login!');
        } catch (Exception $ex) {
        	return redirect()->route('/register')->with('error', $ex->getMessage());
        }
    }

    public function login(Request $request)
    {
    	$request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
        	$admin = $this->authService->getAdminByEmail($request->email);

        	$isAuthenticate = $this->authService->loginAdmin($admin, $request->all());
        	if (!$isAuthenticate) {
        		return redirect()->route('admin.login')->with('error', 'Invalid credentials. Try Again!');
        	}

        	return redirect()->route('dashboard')->with('success', 'Welcome, succussfully logged in.');
        } catch(ModelNotFoundException $ex) {
        	return redirect()->route('admin.register')->with('info', 'Email not found. Register first');

        }
    }
}
