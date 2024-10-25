<?php

namespace App\Models\Product\Traits\Method;

use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Class ProductVariationMethod.
 */
trait ProductMethod
{
    public function restoreDeleted()
    {
        $this->deleted_at = null;
        $this->save();
    }
    public function processDelete(): static
    {
        DB::beginTransaction();
        try {
            $this->forceDelete();
        } catch (Exception $e) {
            DB::rollBack();
            throw new \Exception('There was a problem while deleting the product.');
        }
        DB::commit();
        return $this;
    }
}
