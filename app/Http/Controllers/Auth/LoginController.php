<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Libraries\EmailVerificationHelper;
use App\Models\User;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if(empty(Auth::user())){
            session()->flash( 'show_login_modal', true );
            return redirect()->route('home');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $response = [];

        $this->validateLogin($request);
        $user = User::where('email', $request->email)->first();
        $response['success'] = false;
            $response['message'] = 'Your email or password is wrong';

        if(isset($user) && !isset($user->email_verified_at)){
            $response['success'] = false;
            $response['message'] = 'Your account is not verified yet';
            return response()->json($response);
            // $sendEmail = EmailVerificationHelper::sendEmail($user);
            // if(isset($sendEmail)){
            //     //return back()->withErrors(['user_verified' => 'User\'s email is not verified. Please verify first. Email verification URL has been sent to your email.']);
            //     $this->error('User\'s email is not verified. Please verify first. Email verification URL has been sent to your email!')->push();
            //     return back();
            // }
        }


        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        // if (method_exists($this, 'hasTooManyLoginAttempts') &&
        //     $this->hasTooManyLoginAttempts($request)) {
        //     $this->fireLockoutEvent($request);

        //     return $this->sendLockoutResponse($request);
        // }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            $response['success'] = true;
            $response['message'] = 'Login successful';
            $response['redirect_url'] = '/my-yachts';
            if(isset($request['is_sell_boat']) && $request['is_sell_boat'] == 'true'){
                $response['redirect_url'] = '/select-plan';
            }
            if($user->role == 'admin'){
                $response['redirect_url'] = '/admin/dashboard';
            }

            return response()->json($response);
        }
       // return response()->json($response, 422);

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        // $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

     protected function authenticated(Request $request, $user)
    {
        // to admin dashboard
        if($user->isAdmin()) {
            return redirect('/admin/dashboard');
        }

        // to user dashboard
        else if($user->isUser()) {
            return redirect('/my-yachts');
        }

        abort(404);
    }


    protected function redirectTo()
    {
        if (auth()->user()->role == 'admin') {
            return '/admin/dashboard';
        }
        return '/my-yachts';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {

        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'is_sell_boat' => 'nullable'
        ]);
    }
}
