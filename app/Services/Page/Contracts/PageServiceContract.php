<?php

namespace App\Services\Page\Contracts;

use App\Enums\PageTypeEnum;
use App\Services\Page\Dtos\PageDto;
use App\Services\Page\Exceptions\PageCreateFailedException;
use App\Services\Page\Exceptions\PageDeleteFailedException;
use App\Services\Page\Exceptions\PageNotFoundException;
use App\Services\Page\Exceptions\PageUpdateFailedException;

interface PageServiceContract
{
    /**
     * @param string $title
     * @param string $content
     * @param string $type
     *
     * @return void
     * @throws PageCreateFailedException
     */
    public function create(string $title, string $content, string $type): void;

    /**
     * @param int    $id
     * @param string $title
     * @param string $content
     * @param string $type
     *
     * @return void
     * @throws PageNotFoundException
     * @throws PageUpdateFailedException
     */
    public function update(int $id, string $title, string $content, string $type): void;

    /**
     * @param int $id
     *
     * @return void
     * @throws PageDeleteFailedException
     * @throws PageNotFoundException
     */
    public function delete(int $id): void;

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
