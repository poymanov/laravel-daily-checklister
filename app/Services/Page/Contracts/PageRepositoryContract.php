<?php

namespace App\Services\Page\Contracts;

use App\Services\ChecklistGroup\Exceptions\ChecklistGroupNotFoundException;
use App\Services\Page\Dtos\PageCreateDto;
use App\Services\Page\Dtos\PageDto;
use App\Services\Page\Exceptions\PageCreateFailedException;
use App\Services\Page\Exceptions\PageNotFoundException;

interface PageRepositoryContract
{
    /**
     * @param PageCreateDto $pageCreateDto
     *
     * @return void
     * @throws PageCreateFailedException
     */
    public function create(PageCreateDto $pageCreateDto): void;

    /**
     * @return PageDto[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     *
     * @return PageDto
     * @throws PageNotFoundException
     */
    public function findOneById(int $id): PageDto;
}
