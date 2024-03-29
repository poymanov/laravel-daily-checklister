<?php

namespace App\Services\Page\Repositories;

use App\Models\Page;
use App\Services\Page\Contracts\PageRepositoryContract;
use App\Services\Page\Dtos\PageCreateDto;
use App\Services\Page\Dtos\PageDto;
use App\Services\Page\Dtos\PageUpdateDto;
use App\Services\Page\Exceptions\PageCreateFailedException;
use App\Services\Page\Exceptions\PageDeleteFailedException;
use App\Services\Page\Exceptions\PageNotFoundException;
use App\Services\Page\Exceptions\PageUpdateFailedException;
use App\Services\Page\Factories\PageDtoFactory;

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
        $page->type    = $pageCreateDto->type->value;

        if (!$page->save()) {
            throw new PageCreateFailedException();
        }
    }

    /**
     * @param int           $id
     * @param PageUpdateDto $pageUpdateDto
     *
     * @return void
     * @throws PageNotFoundException
     * @throws PageUpdateFailedException
     */
    public function update(int $id, PageUpdateDto $pageUpdateDto): void
    {
        $page = $this->findModelById($id);

        $page->title   = $pageUpdateDto->title;
        $page->content = $pageUpdateDto->content;
        $page->type    = $pageUpdateDto->type->value;

        if (!$page->save()) {
            throw new PageUpdateFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $page = $this->findModelById($id);

        if (!$page->delete()) {
            throw new PageDeleteFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return PageDtoFactory::createFromModelsList(Page::select('id', 'title', 'content', 'type')->get());
    }

    /**
     * @inheritDoc
     */
    public function findOneById(int $id): PageDto
    {
        return PageDtoFactory::createFromModel($this->findModelById($id));
    }

    /**
     * @inheritDoc
     */
    public function findOneByType(string $type): PageDto
    {
        return PageDtoFactory::createFromModel($this->findModelByType($type));
    }

    /**
     * Получение модели по ID
     *
     * @param int $id
     *
     * @return Page
     * @throws PageNotFoundException
     */
    private function findModelById(int $id): Page
    {
        $page = Page::find($id);

        if (!$page) {
            throw new PageNotFoundException($id);
        }

        return $page;
    }

    /**
     * Получение модели по типу
     *
     * @param string $type
     *
     * @return Page
     * @throws PageNotFoundException
     */
    private function findModelByType(string $type): Page
    {
        $page = Page::whereType($type)->first();

        if (!$page) {
            throw new PageNotFoundException(null, $type);
        }

        return $page;
    }
}
