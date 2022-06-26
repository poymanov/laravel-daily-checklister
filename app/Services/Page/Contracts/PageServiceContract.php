<?php

namespace App\Services\Page\Contracts;

use App\Services\Page\Dtos\PageDto;
use App\Services\Page\Exceptions\PageCreateFailedException;
use App\Services\Page\Exceptions\PageNotFoundException;
use App\Services\Page\Exceptions\PageUpdateFailedException;

interface PageServiceContract
{
    /**
     * @param string $title
     * @param string $content
     *
     * @return void
     * @throws PageCreateFailedException
     */
    public function create(string $title, string $content): void;

    /**
     * @param int    $id
     * @param string $title
     * @param string $content
     *
     * @return void
     * @throws PageNotFoundException
     * @throws PageUpdateFailedException
     */
    public function update(int $id, string $title, string $content): void;

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
