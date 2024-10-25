<?php

namespace App\Models\Product;

use App\Models\Product\Traits\Attribute\ProductAttribute;
use App\Models\Product\Traits\Method\ProductMethod;
use App\Models\Product\Traits\Relationship\ProductRelationship;
use App\Models\Product\Traits\Scope\ProductScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use ProductRelationship;
    use ProductMethod;
    use ProductScope;
    use ProductAttribute;
    use SoftDeletes;

    protected $table = 'products';
    public $incrementing = false;
    protected $fillable = [
        'id','name', 'sku', 'status', 'variations', 'price', 'currency',
    ];
}
