<?php

namespace App\Services;

use App\Interfaces\ProductImporterInterface;
use App\Jobs\NotifyCustomers;
use App\Jobs\SendWarehouseNotification;
use App\Models\Product\Product;
use App\Models\ProductVariation\ProductVariation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductImporterService implements ProductImporterInterface
{
    public function importFromCSV(string $filePath)
    {
        $lines = handle_file($filePath);
        $i = 0;
        foreach ($lines as $line) {
            if (empty(array_filter($line))) {
                continue;
            }
            $data = prepare_data($line);
            $existingProduct = Product::find($data['id']);
            if ($existingProduct) {
                $existingProduct->processDelete();
            }

            $errors = $this->validateProductData($data);
            if (!empty($errors)) {
                \Log::warning('Validation failed for item:', ['item' => json_encode($data), 'errors' => $errors]);
                continue;
            }
            $product = $this->saveProduct($data);
            $this->saveProductVariations($product);

            SendWarehouseNotification::dispatch($product);
            NotifyCustomers::dispatch($product);
            $i ++;
        }
        $this->softDeleteProductNoLongerExists($lines);
        return $i;
    }

    protected function validateProductData(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'nullable|string|max:255',
            'sku' => 'nullable|string|unique:products,sku,' . ($data['id'] ?? 'NULL'),
            'price' => 'nullable|numeric|between:0,99999.99|regex:/^\d{0,5}(\.\d{1,2})?$/',
            'currency' => 'nullable|string|max:20',
            'status' => 'nullable|string|max:255',
        ]);
        return $validator->errors()->all();
    }

    public function saveProduct(array $data)
    {
        DB::beginTransaction();
        try {
         $product =   Product::withTrashed()->updateOrCreate(
                ['id' => $data['id']],
                $data
            );
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('There was a problem while saving the product.');
        }
        DB::commit();
        return $product;
    }
    public function saveProductVariations(Product $product)
    {
        if (!empty($product->variations)) {
            $variations = json_decode($product->variations);
            foreach ($variations as $variation) {
                DB::beginTransaction();
                try {
                    ProductVariation::updateOrCreate(
                        [
                            'product_id' => $product->id,
                        ],
                        [
                            'name' => $variation->name,
                            'value' => $variation->value,
                        ]
                    );
                }catch (\Exception $e) {
                    DB::rollBack();
                    throw new \Exception('There was a problem while saving the product variations.');
                }
                DB::commit();
            }
        }
    }
    private function deleteExistingProductbySku(string $sku)
    {
        DB::beginTransaction();
        try {
            Product::whereNotIn('sku', $sku)->update(['deleted_at' => now()]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('There was a problem while soft deleting the product.');
        }
        DB::commit();
    }
    private function softDeleteProductNoLongerExists(array $lines)
    {
        $existingProducts = Product::all();
        $importedIds = array_column($lines, 'id');
        foreach ($existingProducts as $key => $product) {
            if (!in_array($product->id, $importedIds)) {
                DB::beginTransaction();
                try {
                    $product->delete();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw new \Exception('There was a problem while soft deleting the product.');
                }
                DB::commit();
            }
        }
    }

}
