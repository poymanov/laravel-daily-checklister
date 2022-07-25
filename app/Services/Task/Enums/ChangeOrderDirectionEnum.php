<?php

namespace App\Services\Task\Enums;

enum ChangeOrderDirectionEnum: string
{
    case PREV = 'prev';

    case NEXT = 'next';
}
