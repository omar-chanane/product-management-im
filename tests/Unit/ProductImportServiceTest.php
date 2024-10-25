<?php

namespace Tests\Unit;

use App\Models\Product\Product;
use App\Models\ProductVariation\ProductVariation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductImportServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testProductStoreData()
    {
        $product= new Product();
        $data = [
            'id' => 60,
            'name' => 'Name of Product for test',
            'sku' => 'SKU',
            'price' => 122.99,
            'currency' => 'MAD',
            'status' => 'sale',
        ];
        $product->updateOrCreate($data);
        $this->assertDatabaseHas('products',[
            'id'=> 60
        ]);
        $productVariation= new ProductVariation();
        $data = [
            'name' => 'Name of variation for test',
            'value' => 'SKU',
            'product_id' => 60,
        ];
        $productVariation->updateOrCreate($data);
        $this->assertDatabaseHas('product_variations',[
            'name'=> 'Name of variation for test'
        ]);
    }
}
