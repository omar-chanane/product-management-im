<?php

namespace App\Interfaces;

interface ProductImporterInterface
{
    public function importFromCSV(string $filePath);
}
