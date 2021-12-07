<?php

namespace App\Http\Middleware;

use App\Traits\GoogleAuthenticator;
use Closure;
use Illuminate\Routing\Route;

class IPRVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user['ip_restriction'] === "DISABLED" ) {
            return $next($request);
        }
        if ($user->ips()->where('ip',$this->getIp())->first() !== null)
            return $next($request);

        if( $request->is('api/*')){
            return response()->json(['errors' => ['error' => 'IP Address is not authorized for this actions.']],422);
        }

        return redirect('/ip_address/blocked');
    }
    private function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }
}
