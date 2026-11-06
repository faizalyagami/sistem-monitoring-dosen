<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dosen;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function username()
    {
        return 'nik';
    }

    protected function attemptLogin(Request $request)
    {
        $loginInput = $request->input('nik');
        $password = $request->input('password');


        $user = User::where('email', $loginInput)->first();

        if (!$user) {

            $dosen = Dosen::where('nik', $loginInput)->first();

            if ($dosen) {
                $user = User::where('dosen_id', $dosen->id)->first();
            }
        }


        if ($user && Hash::check($password, $user->password)) {

            if ($user->status !== 'active') {
                throw ValidationException::withMessages([
                    'nik' => ['Akun Anda tidak aktif. Hubungi administrator.'],
                ]);
            }

            Auth::login($user, $request->filled('remember'));

            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            return true;
        }

        return false;
    }


    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'nik' => ['NIK/Email atau password yang Anda masukkan salah.'],
        ]);
    }


    protected function validateLogin(Request $request)
    {
        $request->validate([
            'nik' => 'required|string',
            'password' => 'required|string',
        ]);
    }


    protected function authenticated(Request $request, $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dosen.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
