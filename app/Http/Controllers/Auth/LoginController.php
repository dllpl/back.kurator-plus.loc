<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\SocialAccount;
use App\Http\Controllers\Controller;
use App\Models\Core\SocialProvider;
use App\Models\Core\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Throwable;

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

    use AuthenticatesUsers, RedirectToClient;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/home';

    private const EMAIL = 'email';
    private const TIN = 'inn';

    private $username = self::EMAIL;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'redirectToProvider', 'handleProviderCallback']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        if (!preg_match('~@~', $request->email)) {
            $this->changeUsername($request, self::TIN);
        }

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        if ($this->username !== self::EMAIL) {
            $this->changeUsername($request, self::EMAIL);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function logout(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        if ($user) {
            $user->tokens()->delete();
        }

        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * Redirect the user to the social provider authentication page.
     *
     * @param string $driver
     * @return SymfonyRedirectResponse
     */
    public function redirectToProvider(string $driver): SymfonyRedirectResponse
    {
        $this->setProviderRedirect($driver);
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @param string $driver
     * @return RedirectResponse|Response
     */
    public function handleProviderCallback(string $driver)
    {
        $this->setProviderRedirect($driver);
        try {
            $socialUser = Socialite::driver($driver)->user();
        }
        catch (Throwable $exception) {
            return redirect()->back();
        }

        try {
            $user = app(SocialAccount::class)->findOrCreate($driver, $socialUser);
        }
        catch (AuthorizationException $exception) {
            // todo: need to simplify
            return redirect(
                url()->previous() . '#/user?type=error&message=' . rawurlencode($exception->getMessage())
            );
        }

        $this->guard()->login($user);
        return $this->sendLoginResponse(request());
    }

    /**
     * @param string $driver
     */
    protected function setProviderRedirect(string $driver): void
    {
        config([
            "services.$driver.redirect" => route('provider.callback', ['driver' => $driver])
        ]);
    }

    /**
     * Show the application's login form.
     *
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('auth.login')->with('providers', SocialProvider::get());
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * @param Request $request
     * @param string $username
     */
    private function changeUsername(Request $request, string $username): void
    {
        $request->request->set($username, $request->{$this->username});
        $request->request->remove($this->username);
        $this->username = $username;
    }
}
