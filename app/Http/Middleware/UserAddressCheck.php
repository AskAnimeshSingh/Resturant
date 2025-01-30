<?php

namespace App\Http\Middleware;

use App\Models\UserAddress;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // echo "dev";exit;
        if (Auth::guard('web')->check()) {
            $userAddress = UserAddress::where(['user_id' => Auth::user()->id])->get();
            if(count($userAddress) > 0){
                return $next($request);
            }else{
                return redirect(route('website.user.address.add'));
            }
        }else{
            return redirect(route('website.login'));
        }

    }
}
