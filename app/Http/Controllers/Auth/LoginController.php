<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Post;
use App\Providers\RouteServiceProvider;
use App\User;
use Exception;
use Google_Client;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        $take_posts = Post::latest()->take(2)->get();
        return view('auth.login', compact('take_posts'));
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider(string $provider)
    {
        try {
            $scopes = config("services.$provider.scopes") ?? [];
            if (count($scopes) === 0) {
                return Socialite::driver($provider)->redirect();
            } else {
                return Socialite::driver($provider)->scopes($scopes)->redirect();
            }
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function handleProviderCallback(string $provider)
    {
        try {
            $data = Socialite::driver($provider)->user();

            return $this->handleSocialUser($provider, $data);
        } catch (\Exception $e) {
            return redirect('login')->withErrors(['authentication_deny' => 'Login with '.ucfirst($provider).' failed. Please try again.']);
        }
    }

    public function handleSocialUser(string $provider, object $data)
    {
        $user = User::where([
            "social->{$provider}->id" => $data->id,
        ])->first();

        if (!$user) {
            $user = User::where([
                'email' => $data->email,
            ])->first();
        }

        if (!$user) {
            return $this->createUserWithSocialData($provider, $data);
        }

        $social = $user->social;
        $social[$provider] = [
            'id' => $data->id,
            'token' => $data->token
        ];
        $user->social = $social;
        $user->save();

        return $this->socialLogin($user);
    }

    public function createUserWithSocialData(string $provider, object $data)
    {
        try {
            $user           = new User;
            $user->name     = $data->name;
            $user->email    = $data->email;
            $user->role     = json_encode(["AUTHOR"]);
            $user->social   = [
                $provider => [
                    'id'    => $data->id,
                    'token' => $data->token,
                ],
            ];

            if ($user instanceof MustVerifyEmail) {
                $user->markEmailAsVerified();
            }

            $user->save();

            return $this->socialLogin($user);
        } catch (Exception $e) {
            return redirect('login')->withErrors(['authentication_deny' => 'Login with '.ucfirst($provider).' failed. Please try again.']);
        }
    }

    // public function one_tap()
    // {
    //     $google_oauth_client_id = "915892584672-gdkk28qtnvko1murg3gung6ihhhvelli.apps.googleusercontent.com";
    //     $client = new Google_Client([ 'client_id' => $google_oauth_client_id ]);
    //     $id_token = $_POST["id_token"];

    //     $payload = $client->verifyIdToken($id_token);
    //     if ($payload && $payload['aud'] == $google_oauth_client_id)
    //     {
    //         try {
    //             $user           = new User();
    //             $user->name     = $payload["name"];
    //             $user->email    = $payload["email"];
    //             $user->role     = json_encode(["AUTHOR"]);
    //             $user->social   = [
    //                 "google_one_tap" => [
    //                     'id'    => $payload['sub'],
    //                     'token' => $id_token,
    //                 ],
    //             ];

    //             if ($user instanceof MustVerifyEmail) {
    //                 $user->markEmailAsVerified();
    //             }

    //             $user->save();

    //             return $this->socialLogin($user);
    //         } catch (Exception $e) {
    //             return redirect('login')->withErrors(['authentication_deny' => 'Login with google_one_tap failed. Please try again.']);
    //         }

    //         // get user information from Google
    //         // $user_google_id = $payload['sub'];

    //         // $name = $payload["name"];
    //         // $email = $payload["email"];
    //         // $picture = $payload["picture"];

    //         // // login the user
    //         // $_SESSION["user"] = $user_google_id;

    //         // // send the response back to client side
    //         // return "Successfully logged in. " . $user_google_id . ", " . $name . ", " . $email . ", " . $picture;
    //     }
    // }

    public function socialLogin(User $user)
    {
        Auth::loginUsingId($user->id);

        return redirect($this->redirectTo);
    }
}
