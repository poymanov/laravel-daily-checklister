<?php

namespace App\Services\Page\Repositories;

use App\Models\Page;
use App\Services\Page\Contracts\PageRepositoryContract;
use App\Services\Page\Dtos\PageCreateDto;
use App\Services\Page\Exceptions\PageCreateFailedException;

class PageRepository implements PageRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(PageCreateDto $pageCreateDto): void
    {
        $page          = new Page();
        $page->title   = $pageCreateDto->title;
        $page->content = $pageCreateDto->content;

        if (!$page->save()) {
            throw new PageCreateFailedException();
        }
    }
}
