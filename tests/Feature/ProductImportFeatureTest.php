<?php

namespace Tests\Feature;

use App\Models\Product\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductImportFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_products_command()
    {
        $response = $this->artisan('products:import', ['file' => 'Laravel-Challenge\products-2.csv']);
        $response->expectsOutput('Updated 41 products.')
            ->assertExitCode(0);
    }
    public function test_sync_products_command()
    {
        $response = $this->artisan('sync:products');
        $response->expectsOutput('Product sync completed successfully.')
            ->assertExitCode(0);
    }
}
