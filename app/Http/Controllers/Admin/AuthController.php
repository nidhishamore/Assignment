<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

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
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
    	$request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:50',
            'password' => 'required|string|min:8|confirmed',
        ]);
    	DB::beginTransaction();
        try {
        	$this->authService->registerAdmin($request->all());

        	DB::commit();

        	return redirect()->route('admin.login')->with('success', 'You have been successfully registered. Please Login!');
        } catch (Exception $ex) {
            return $ex->getMessage();
            DB::rollback();
        	return redirect()->route('admin.register')->with('error', $ex->getMessage());
        }
    }

    public function login(Request $request)
    {
    	$request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials['email'] = $request->email;
        $credentials['password'] = $request->password;

        try {
            $admin = $this->authService->getAdminByEmail($request->email);

            if(Auth::guard('admin')->attempt($credentials)) {
                $this->authService->storeAdminToken($request->_token);
                return redirect()->route('admin.dashboard')->with('success', 'Welcome, succussfully logged in.');
            }

            return redirect()->route('admin.login')->with('error', 'Invalid credentials. Try Again!');
        	
        } catch(ModelNotFoundException $ex) {
        	return redirect()->route('admin.register')->with('info', 'Email not found. Register first');

        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login')->with('success', 'Logout successfully');
    }
}
