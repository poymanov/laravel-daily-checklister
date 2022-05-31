<?php

namespace Tests\Helpers;

use Tests\Helpers\RouteBuilder\AuthBuilder;
use Tests\Helpers\RouteBuilder\ChecklistBuilder;
use Tests\Helpers\RouteBuilder\ChecklistGroupBuilder;
use Tests\Helpers\RouteBuilder\CommonBuilder;

class RouteBuilderHelper
{
    private static ?RouteBuilderHelper $instance = null;

    public CommonBuilder $common;
    public AuthBuilder $auth;
    public ChecklistGroupBuilder $checklistGroup;
    public ChecklistBuilder $checklist;

    private function __construct()
    {
        $this->common         = new CommonBuilder();
        $this->auth           = new AuthBuilder();
        $this->checklistGroup = new ChecklistGroupBuilder();
        $this->checklist      = new ChecklistBuilder($this->checklistGroup);
    }

    public static function getInstance(): RouteBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
