<?php

namespace Rakadprakoso\Ceemas\app\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Rakadprakoso\Ceemas\app\Models\Account;
use Cookie;

class AuthenticationController extends Controller
{

    public function loginForm()
    {
        return view('ceemas::admin.authentication.login');
        /*return view('auth.login',[
            'title' => 'Admin Login',
            'loginRoute' => 'admin.login',
            'forgotPasswordRoute' => 'admin.password.request',
        ]);*/
    }

    /**
     * Login the admin.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {

        $this->validate($request,
            ['username'=>'required'],
            ['password'=>'required']
        );

        $user = $request->input('username');
        $pass = $request->input('password');

        $account = Account::where('username',$user)->orWhere('email', $user)->first();

        if($account==null){
            return back()->with('status','Account not found!');
        } else{
            if (Hash::check($pass, $account->password)) {
                $request->session()->put('user_id',$account->id);
                $request->session()->put('username',$user);
                $request->session()->put('name',$account->name);
                if ($request->remember_me=="on") {
                    $cookie = Hash::make($request->_token);
                    //Cookie::make('remember_', 'test', 3600*24*365*5);

                    $account = Account::find($account->id);
                    $account->remember_token = $cookie;
                    $account->save();


                    Cookie::queue('remember', Crypt::encryptString($user), 3600*24*12);
                    Cookie::queue('remember_token', $cookie, 3600*24*12);
                    //setcookie('remember_'.hash('md5', $user), $cookie, time() + (86400 * 30), "/");

                    //return response(redirect()->route('admin.dashboard'))
                    //->withCookie('remember_'.hash('md5', $user), $cookie, 3600*24*365);
                }


                return redirect()->route('admin.dashboard');
            } else{
                return back()->with('status','Password Salah');
            }


        }

        /*$this->validator($request);

        if(Auth::guard('admin')->attempt($request->only('email','password'),$request->filled('remember'))){
            //Authentication passed...
            return redirect()
                ->intended(route('admin.home'))
                ->with('status','You are Logged in as Admin!');
        }

        //Authentication failed...
        return $this->loginFailed();*/
    }

    /**
     * Logout the admin.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {

        $account = Account::where('username',$request->session()->get('username'))->first();
        //$account = Account::find($account->id);
        $account->remember_token = null;
        $account->save();
        Cookie::queue(Cookie::forget('remember'));
        Cookie::queue(Cookie::forget('remember_token'));
        //$cookie = Cookie::forget($cookie_name);
        $request->session()->forget('username');
        $request->session()->flush();
        return redirect()->route('admin.dashboard');
    }

    /**
     * Validate the form data.
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validator(Request $request)
    {
      //validation rules.
        $rules = [
            'email'    => 'required|email|exists:admins|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
        ];

        //validate the request.
        $request->validate($rules,$messages);
    }

    /**
     * Redirect back after a failed login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
        return redirect()
        ->back()
        ->withInput()
        ->with('error','Login failed, please try again!');
    }

    /*public function login(){
	    return view('ceemas::admin.authentication.login');
    }*/
}
