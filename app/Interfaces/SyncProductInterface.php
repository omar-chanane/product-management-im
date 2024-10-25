<?php

namespace App\Interfaces;

interface SyncProductInterface
{
    public function syncFromApi(array $products);
}
