<?php

namespace App\Services\Page\Factories;

use App\Models\Page;
use App\Services\Page\Dtos\PageDto;
use Illuminate\Database\Eloquent\Collection;
use Mews\Purifier\Facades\Purifier;

class PageDtoFactory
{
    /**
     * @param Collection $models
     *
     * @return array
     */
    public static function createFromModelsList(Collection $models): array
    {
        $dtos = [];

        foreach ($models as $model) {
            $dtos[] = self::createFromModel($model);
        }

        return $dtos;
    }

    /**
     * @param Page $page
     *
     * @return PageDto
     */
    public static function createFromModel(Page $page): PageDto
    {
        $dto          = new PageDto();
        $dto->id      = $page->id;
        $dto->title   = $page->title;
        $dto->content = Purifier::clean($page->content);

        return $dto;
    }
}
