<?php

namespace App\Services\ChecklistGroup\Contracts;

use App\Services\ChecklistGroup\Dtos\ChecklistGroupDto;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupCreateFailedException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupDeleteFailedException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupNotFoundException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupUpdateFailedException;

interface ChecklistGroupServiceContract
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

    /**
     * Обновление группы чеклистов
     *
     * @param int    $id
     * @param string $name
     *
     * @return void
     * @throws ChecklistGroupNotFoundException
     * @throws ChecklistGroupUpdateFailedException
     */
    public function update(int $id, string $name): void;

    /**
     * @param int $id
     *
     * @return void
     * @throws ChecklistGroupDeleteFailedException
     * @throws ChecklistGroupNotFoundException
     */
    public function delete(int $id): void;

    /**
     * @return ChecklistGroupDto[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     *
     * @return ChecklistGroupDto
     * @throws ChecklistGroupNotFoundException
     */
    public function findOneById(int $id): ChecklistGroupDto;
}
