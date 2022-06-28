<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        /** @var User $admin */
        $admin = User::factory(['email' => 'admin@checklister.test'])->create();

        $admin->assignRole(RoleEnum::ADMIN->value);

        User::factory(['email' => 'user@checklister.test'])->create();
    }
}
