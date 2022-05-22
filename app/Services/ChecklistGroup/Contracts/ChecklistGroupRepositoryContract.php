<?php

namespace App\Services\ChecklistGroup\Contracts;

use App\Services\ChecklistGroup\Exceptions\ChecklistGroupCreateFailedException;

interface ChecklistGroupRepositoryContract
{
    /**
     * Создание группы чеклистов
     *
     * @param string $name
     *
     * @return void
     * @throws ChecklistGroupCreateFailedException
     */
    public function create(string $name): void;
}
