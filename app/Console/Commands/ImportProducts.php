<?php

namespace App\Console\Commands;

use App\Services\ProductImporterService;
use Illuminate\Console\Command;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports products into database';
    protected $importer;
    public function __construct(ProductImporterService $importer)
    {
        parent::__construct();
        $this->importer = $importer;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        try {
            $updatedCount = $this->importer->importFromCSV($filePath);
            $this->info("Updated {$updatedCount} products.");
        } catch (\Exception $e) {
            $this->error('Import failed: ' . $e->getMessage());
        }
    }
}
