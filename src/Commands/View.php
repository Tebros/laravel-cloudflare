<?php

namespace Adams\Cloudflare\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class View extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloudflare:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View list of trust proxies IPs stored in cache.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $proxies = array_map(function ($item) {
            return [
                'address' => $item
            ];
        }, Cache::get('cloudflare.proxies', []));

        $this->table(['Address'], $proxies);
    }
}
