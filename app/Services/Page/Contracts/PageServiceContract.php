<?php

namespace App\Services\Page\Contracts;

use App\Services\Page\Exceptions\PageCreateFailedException;

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
}
