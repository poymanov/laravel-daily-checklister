<?php

namespace App\Services\Page;

use App\Services\Page\Contracts\PageRepositoryContract;
use App\Services\Page\Contracts\PageServiceContract;
use App\Services\Page\Dtos\PageCreateDto;
use App\Services\Page\Dtos\PageDto;
use App\Services\Page\Dtos\PageUpdateDto;
use Mews\Purifier\Facades\Purifier;

class PageService implements PageServiceContract
{
    public function __construct(
        private PageRepositoryContract $pageRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(string $title, string $content): void
    {
        $pageCreateDto          = new PageCreateDto();
        $pageCreateDto->title   = $title;
        $pageCreateDto->content = Purifier::clean($content);

        $this->pageRepository->create($pageCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, string $title, string $content): void
    {
        $pageUpdateDto          = new PageUpdateDto();
        $pageUpdateDto->title   = $title;
        $pageUpdateDto->content = Purifier::clean($content);

        $this->pageRepository->update($id, $pageUpdateDto);
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this->pageRepository->findAll();
    }

    /**
     * @inheritDoc
     */
    public function findOneById(int $id): PageDto
    {
        return $this->pageRepository->findOneById($id);
    }
}
