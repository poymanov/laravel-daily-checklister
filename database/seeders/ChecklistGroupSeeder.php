<?php

namespace Database\Seeders;

use App\Models\ChecklistGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ChecklistGroup::factory(10)->create();
    }
}
