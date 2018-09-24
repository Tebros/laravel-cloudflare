<?php

namespace Adams\Cloudflare\Middleware;

use Fideloper\Proxy\TrustProxies;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TrustCloudflare extends TrustProxies
{

    public function __construct(Repository $config)
    {
        parent::__construct($config);
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $existingProxies = $request->getTrustedProxies();
        if(count($existingProxies)==1){
            if($existingProxies[0]===$request->server->get('REMOTE_ADDR')){
                dd('Vorher wurde alles mit * oder so erlaubt!', $existingProxies);
            }
        }

        $proxies = Cache::get('cloudflare.proxies');

        if (!is_null($proxies)) {
            array_push($existingProxies, $proxies);
        }

        dd('Zusammengefasst:', $request->getTrustedProxies());

        return $next($request);
    }

}