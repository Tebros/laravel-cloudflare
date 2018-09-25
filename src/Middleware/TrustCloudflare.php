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
        if (count($existingProxies) == 1) {
            if ($existingProxies[0] === $request->server->get('REMOTE_ADDR')) {
                //trust all proxies (*), so we dont need to add cloudflare proxies!
                return;
            }
        }

        $cfProxies = Cache::get('cloudflare.proxies');

        if (!is_null($cfProxies)) {
            $request->setTrustedProxies(array_merge($existingProxies, $cfProxies), $this->getTrustedHeaderNames());
        }

        return $next($request);
    }

}