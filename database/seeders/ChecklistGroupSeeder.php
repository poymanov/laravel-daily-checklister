<?php

namespace Database\Seeders;

use App\Models\ChecklistGroup;
use Illuminate\Database\Seeder;

class ChecklistGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChecklistGroup::factory(2)->create();
    }
}
