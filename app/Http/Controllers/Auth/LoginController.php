<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Session\Store as SessionStore;
use Session;
use Illuminate\Support\Facades\DB;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider)
    {
        session()->forget('social_reg_source');
        session()->put('social_reg_source', request('source'));

        if($provider=="google"){
            return Socialite::driver($provider)->redirect();
        }
    }

    public function handleGoogleCallback()
    {
        $response = request()->input();
        if(isset($response['error'])){
            return redirect('/login');
        }

        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('provider_id', $user->id)->where('provider', 'google')->first();
            if($finduser){
                if(session()->get('social_reg_source')=="register"){
                    session()->forget('social_reg_source');
                    return redirect('login')->with('message', 'You are already registerd. Please login with Google.');
                }
                if(session()->get('social_reg_source')=="login"){
                    session()->forget('social_reg_source');
                    Auth::login($finduser);
                    if(auth()->user()->profile_status)
                        return redirect('/home');
                    else
                        return redirect('/profile');
                }
                
            }else{

                if(session()->get('social_reg_source')=="login"){
                    session()->forget('social_reg_source');
                    return redirect('register')->with('message', 'Please make a registration. Sign Up With Google');
                }
                                 
                $newUser = User::create([
                    'first_name' => $user->name,
                    'email'    => $user->email,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'provider' => "google",
                    'provider_id' => $user->id,
                ]);
    
                Auth::login($newUser);
                return redirect('/profile');
                 
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function findOrCreateGoogleUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        
        if ($authUser) {

            if($authUser->provider_id==NULL){
                User::where('email', $user->email)->update(['provider' => $provider, 'provider_id' => $user->id]);
            }
            
            return $authUser;
        }

        DB::table('google_users')->where('provider_id', $user->id)->delete();
        
        DB::table('google_users')->insert([
            'name'     => $user->name,
            'email'    => $user->email,
            'created_at' => date('Y-m-d H:i:s'),
            'provider' => $provider,
            'provider_id' => $user->id,
            'profile_photo' => $user->avatar,
        ]);
        $this->provider_id = $user->id;
        return 'New';
    }
}
