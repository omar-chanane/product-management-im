<?php

namespace App\Console\Commands;

use App\Accessors\GetProductsFromApi;
use App\Services\SyncProductService;
use Illuminate\Console\Command;

class SyncProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync products from external API';
    protected $sync;

    public function __construct(SyncProductService $sync)
    {
        parent::__construct();
        $this->sync = $sync;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = GetProductsFromApi::getProducts();
        if (!$response ) {
            $this->error('Failed to fetch products from the API.');
        }else {
            $products = json_decode($response);

            $this->sync->syncFromApi($products);
            $this->info('Product sync completed successfully.');
        }
    }
}
