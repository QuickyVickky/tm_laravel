<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use App\Models\Admin;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /*if(Session::has('adminid')){
            $count = Admin::where('id', Session::get('adminid'))->where('active_session','=',Session::get('adminactivesession'))->count();
            if(!isset($count) || $count!=1){
                $request->session()->flush();
                return redirect()->route('loginpage');
            }
        }*/
        if(!Session::has('adminid') || Session::get('adminactivesession')=='') {
            return redirect()->route('loginpage');
        }
        return $next($request);
    }
}
