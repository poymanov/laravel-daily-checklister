<?php

namespace App\Services\Page\Helpers;

use App\Enums\PageTypeEnum;

class PageTypeHelper
{
    /**
     * @return string[]
     */
    public static function getWithTitles(): array
    {
        return [
            PageTypeEnum::WELCOME->value          => 'Welcome',
            PageTypeEnum::GET_CONSULTATION->value => 'Get Consultation',
        ];
    }
}
