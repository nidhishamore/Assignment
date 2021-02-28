<?php

namespace App\Http\Controllers\User;

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
            'first_name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:customers',
            'last_name' => 'required|string|max:50',
            'contact_number' => 'required|string|size:10',
            'password' => 'required|string|min:8|confirmed',
        ]);
        DB::beginTransaction();
        try {
            $this->authService->registerUser($request->all());

            DB::commit();

            return redirect()->route('user.login')->with('success', 'You have been successfully registered. Please Login!');
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
            return redirect()->route('user.register')->with('error', $ex->getMessage());
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
            $user = $this->authService->getUserByEmail($request->email);

            if(Auth::guard('user')->attempt($credentials)) {
                $this->authService->storeUserToken($request->_token);
                return redirect()->route('user.dashboard')->with('success', 'Welcome, succussfully logged in.');
            }

            return redirect()->route('user.login')->with('error', 'Invalid credentials. Try Again!');
            
        } catch(ModelNotFoundException $ex) {
            return redirect()->route('user.register')->with('info', 'Email not found. Register first');

        }
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();

        return redirect()->route('user.login')->with('success', 'Logout successfully');
    }
}
