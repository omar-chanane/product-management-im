<?php

namespace App\Jobs;

use App\Accessors\GetProductsFromApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateThirdPartyData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {

    }
    public function handle()
    {
        sleep(2);
        $response = GetProductsFromApi::getProducts();
        if($response){
            \Log::info("Third-party data updated");
        }else{
            \Log::error("Failed to update third-party data");
        }



    }
}
