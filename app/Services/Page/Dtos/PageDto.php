<?php

namespace App\Services\Page\Dtos;

use App\Enums\PageTypeEnum;

class PageDto
{
    public int $id;

    public string $title;

    public string $content;

    public PageTypeEnum $type;
}
