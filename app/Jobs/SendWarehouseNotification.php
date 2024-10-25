<?php

namespace App\Jobs;

use App\Models\Product\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWarehouseNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function handle(): void
    {
        sleep(2);
        \Log::info("Warehouse notified about product update: " . $this->product->name);
    }
}
