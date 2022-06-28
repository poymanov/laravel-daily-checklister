<?php

namespace App\Services\Page\Dtos;

use App\Enums\PageTypeEnum;

class PageUpdateDto
{
    public string $title;

    public string $content;

    public PageTypeEnum $type;
}
