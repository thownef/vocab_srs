<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MongoReset extends Command
{
    protected $signature = 'mongo:reset';
    protected $description = 'Drop all MongoDB collections';

    public function handle()
    {
        $collections = DB::connection('mongodb')->getMongoDB()->listCollections();

        foreach ($collections as $collection) {
            $name = $collection->getName();
            DB::connection('mongodb')->getMongoDB()->dropCollection($name);
            $this->info("Dropped: $name");
        }

        $this->info('MongoDB reset hoàn tất ✅');
    }
}
