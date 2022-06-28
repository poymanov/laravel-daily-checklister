<?php

namespace App\Services\Page\Dtos;

use App\Enums\PageTypeEnum;

class PageCreateDto
{
    public string $title;

    public string $content;

    public PageTypeEnum $type;
}
