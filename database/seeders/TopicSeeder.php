<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Topic::insert([
            ['value' => 'topic1'],
            ['value' => 'topic2'],
            ['value' => 'topic3'],
            ['value' => 'topic4'],
            ['value' => 'topic5'],
        ]);
    }
}
