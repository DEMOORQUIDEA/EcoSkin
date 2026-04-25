<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("guest")->except("logout");
        $this->middleware("auth")->only("logout");
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        if (!$user->is_active) {
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Su cuenta ha sido desactivada por normas de seguridad. Por favor, intente más tarde.']);
        }

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/');
    }

    /**
     * Log the user out of the application.
     * Supports both GET and POST requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        // Handle both GET and POST logout requests
        // if ($request->isMethod("get")) {
        //     return $this->handleGetLogout($request);
        // }

        // Default POST logout behavior
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Clear all session data
        $request->session()->flush();

        // Clear authentication cookies
        if ($request->hasCookie("laravel_session")) {
            \Cookie::queue(\Cookie::forget("laravel_session"));
        }

        return $this->loggedOut($request) ?: redirect("/");
    }

    /**
     * Handle GET logout requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // protected function handleGetLogout(\Illuminate\Http\Request $request)
    // {
    //     // Perform the same logout actions as POST
    //     $this->guard()->logout();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     // Clear all session data
    //     $request->session()->flush();

    //     // Clear authentication cookies
    //     if ($request->hasCookie("laravel_session")) {
    //         \Cookie::queue(\Cookie::forget("laravel_session"));
    //     }

    //     // Add a message to indicate successful logout
    //     return redirect("/")
    //         ->with("status", "Has cerrado sesión correctamente.")
    //         ->with("logout_method", "get");
    // }
}
