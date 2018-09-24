<?php

namespace Adams\Cloudflare\Commands;

use Adams\Cloudflare\TrustProxiesLoader;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class Reload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloudflare:reload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload trust proxies IPs and store in cache.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $loader = new TrustProxiesLoader();
        $proxies = $loader->load();

        Cache::forever('cloudflare.proxies', $proxies);

        
        $proxiesTable = array_map(function ($item){
            return [
                'ip' => $item
            ];
        }, Cache::get('cloudflare.proxies', []));

        $this->table(['Cloudflare IP'], $proxiesTable);
        $this->info('Proxies cached successfully.');
    }
}
