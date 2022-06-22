<?php

namespace App\Services\Page\Contracts;

use App\Services\Page\Dtos\PageCreateDto;
use App\Services\Page\Exceptions\PageCreateFailedException;

interface PageRepositoryContract
{
    /**
     * @param PageCreateDto $pageCreateDto
     *
     * @return void
     * @throws PageCreateFailedException
     */
    public function create(PageCreateDto $pageCreateDto): void;
}
