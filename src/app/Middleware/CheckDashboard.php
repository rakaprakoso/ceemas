<?php

namespace Rakadprakoso\Ceemas\app\Middleware;

use Rakadprakoso\Ceemas\app\Traits\helper;
use Illuminate\Support\Facades\Crypt;
use Cookie;

use Closure;


class CheckDashboard
{
    use helper;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($request->session()->has('username')) {

            $user = $request->session()->get('username');
            $role = $this->roleCheck($user);
            //$request->attributes->set('role', $role);
            $request->session()->put('role',$role);
            return $next($request);
        } elseif(Cookie::has('remember')&&Cookie::has('remember_token')){
            $account = $this->cookiesCheck(Cookie::get('remember'),Cookie::get('remember_token'));
            if ($account!=null) {
                $request->session()->put('username',$account->username);
                $request->session()->put('name',$account->name);
                $role = $this->roleCheck($account->username);
                $request->session()->put('role',$role);
                return $next($request);
            }

        }

        //$request->attributes->set('status', false);
        //return $next($request);
        //return redirect()->route('admin.dashboard', ['status' => false]);
        return response()->view('ceemas::admin.authentication.login');

    }
}
