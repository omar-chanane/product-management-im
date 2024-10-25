<?php

namespace App\Services;
use App\Interfaces\SyncProductInterface;
use App\Jobs\UpdateThirdPartyData;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;

class SyncProductService implements SyncProductInterface
{
    protected $importerService;
    public function __construct(ProductImporterService $importerService)
    {
        $this->importerService = $importerService;
    }
   public function syncFromApi($products)
   {
       foreach (array_chunk($products, 100) as $batch) {
           foreach ($batch as $product) {
               $productDetails = prepare_data((array)$product);
               DB::beginTransaction();
               try {
                  $product = $this->importerService->saveProduct($productDetails);
                   $this->importerService->saveProductVariations($product);
                   UpdateThirdPartyData::dispatch();
               }catch (\Exception $e) {
                   DB::rollBack();
                   throw new \Exception('There was a problem while saving the product.');
               }
               DB::commit();
           }
       }
   }
}
