<?php

namespace App\Services\Page\Contracts;

use App\Models\Page;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupNotFoundException;
use App\Services\Page\Dtos\PageCreateDto;
use App\Services\Page\Dtos\PageDto;
use App\Services\Page\Dtos\PageUpdateDto;
use App\Services\Page\Exceptions\PageCreateFailedException;
use App\Services\Page\Exceptions\PageNotFoundException;
use App\Services\Page\Exceptions\PageUpdateFailedException;

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
     * @param int           $id
     * @param PageUpdateDto $pageUpdateDto
     *
     * @return void
     * @throws PageNotFoundException
     * @throws PageUpdateFailedException
     */
    public function update(int $id, PageUpdateDto $pageUpdateDto): void;

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
