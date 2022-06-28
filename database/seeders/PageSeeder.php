<?php

namespace Database\Seeders;

use App\Enums\PageTypeEnum;
use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::factory(['type' => PageTypeEnum::WELCOME->value])->create();
        Page::factory(['type' => PageTypeEnum::GET_CONSULTATION->value])->create();
    }
}
