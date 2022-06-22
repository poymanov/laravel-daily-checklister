<?php

namespace App\Services\Page;

use App\Services\Page\Contracts\PageRepositoryContract;
use App\Services\Page\Contracts\PageServiceContract;
use App\Services\Page\Dtos\PageCreateDto;
use Mews\Purifier\Facades\Purifier;

class PageService implements PageServiceContract
{
    public function __construct(
        private PageRepositoryContract $pageRepository
    ) {
    }

    /**
     * @param string $title
     * @param string $content
     *
     * @return void
     * @throws Exceptions\PageCreateFailedException
     */
    public function create(string $title, string $content): void
    {
        $pageCreateDto          = new PageCreateDto();
        $pageCreateDto->title   = $title;
        $pageCreateDto->content = Purifier::clean($content);

        $this->pageRepository->create($pageCreateDto);
    }
}
