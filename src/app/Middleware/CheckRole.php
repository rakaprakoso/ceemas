<?php

namespace Rakadprakoso\Ceemas\app\Middleware;

use Rakadprakoso\Ceemas\app\Traits\helper;
use Illuminate\Support\Facades\Crypt;
use Cookie;

use Closure;

class CheckRole
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
        return redirect()->route('admin.dashboard');
    }
}
