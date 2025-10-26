<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\UTCDateTime;

class MySQLToMongo extends Command
{
    protected $signature = 'migrate:mysql-to-mongo';
    protected $description = 'Transfer specific tables from MySQL to MongoDB';

    public function handle()
    {
        // Helper chuyển date sang UTCDateTime
        function toMongoDate($value)
        {
            if (empty($value)) return null;
            if ($value instanceof \DateTimeInterface) {
                return new UTCDateTime($value->getTimestamp() * 1000);
            }
            $ts = strtotime($value);
            if ($ts) return new UTCDateTime($ts * 1000);
            return null;
        }
        // $this->toMongoDate = fn($v) => toMongoDate($v);

        $this->info("Migrating vocabulary_words...");
        $wordIdMap = [];

        DB::connection('mysql')->table('vocabulary_words')->orderBy('id')->chunk(500, function ($words) use (&$wordIdMap) {
            foreach ($words as $w) {
                $arr = (array)$w;
                unset($arr['id']);
                $arr['next_review_date'] = toMongoDate($arr['next_review_date'] ?? null);
                $arr['created_date'] = toMongoDate($arr['created_date'] ?? null);
                $arr['created_at'] = toMongoDate($arr['created_at'] ?? null);
                $arr['updated_at'] = toMongoDate($arr['updated_at'] ?? null);
                $mongoId = DB::connection('mongodb')->table('vocabulary_words')->insertGetId($arr);
                $wordIdMap[$w->id] = $mongoId;
            }
        });

        $this->info("Migrating review_schedules...");
        DB::connection('mysql')->table('review_schedules')->orderBy('id')->chunk(500, function ($schedules) use ($wordIdMap) {
            $docs = [];
            foreach ($schedules as $s) {
                $data = (array)$s;
                $data['review_date'] = toMongoDate($data['review_date'] ?? null);
                $data['created_at'] = toMongoDate($data['created_at'] ?? null);
                $data['updated_at'] = toMongoDate($data['updated_at'] ?? null);
                $data['is_completed'] = boolval($data['is_completed']);
                if (isset($wordIdMap[$s->vocabulary_word_id])) {
                    $data['vocabulary_word_id'] = $wordIdMap[$s->vocabulary_word_id];
                }
                unset($data['id']);
                $docs[] = $data;
            }
            DB::connection('mongodb')->table('review_schedules')->insert($docs);
        });

        $this->info("🎉 Complete with relationship mapping!");
    }
}
