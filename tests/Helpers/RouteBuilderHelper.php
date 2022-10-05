<?php

namespace Tests\Helpers;

use Tests\Helpers\RouteBuilder\AuthBuilder;
use Tests\Helpers\RouteBuilder\ChecklistBuilder;
use Tests\Helpers\RouteBuilder\ChecklistGroupBuilder;
use Tests\Helpers\RouteBuilder\CommonBuilder;
use Tests\Helpers\RouteBuilder\DayTaskBuilder;
use Tests\Helpers\RouteBuilder\ImportantTaskBuilder;
use Tests\Helpers\RouteBuilder\PageBuilder;
use Tests\Helpers\RouteBuilder\TaskBuilder;
use Tests\Helpers\RouteBuilder\UserBuilder;

class RouteBuilderHelper
{
    private static ?RouteBuilderHelper $instance = null;

    public CommonBuilder         $common;
    public AuthBuilder           $auth;
    public ChecklistGroupBuilder $checklistGroup;
    public ChecklistBuilder      $checklist;
    public TaskBuilder           $task;
    public PageBuilder           $page;
    public UserBuilder           $user;
    public DayTaskBuilder        $dayTask;
    public ImportantTaskBuilder  $importantTask;

    private function __construct()
    {
        $this->common         = new CommonBuilder();
        $this->auth           = new AuthBuilder();
        $this->checklistGroup = new ChecklistGroupBuilder();
        $this->checklist      = new ChecklistBuilder($this->checklistGroup);
        $this->task           = new TaskBuilder();
        $this->page           = new PageBuilder();
        $this->user           = new UserBuilder();
        $this->dayTask        = new DayTaskBuilder();
        $this->importantTask  = new ImportantTaskBuilder();
    }

    public static function getInstance(): RouteBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
