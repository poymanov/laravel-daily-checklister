<?php

namespace Tests\Helpers;

use Tests\Helpers\ModelBuilder\ChecklistBuilder;
use Tests\Helpers\ModelBuilder\ChecklistGroupBuilder;
use Tests\Helpers\ModelBuilder\PageBuilder;
use Tests\Helpers\ModelBuilder\TaskBuilder;
use Tests\Helpers\ModelBuilder\UserBuilder;

class ModelBuilderHelper
{
    private static ?ModelBuilderHelper $instance = null;

    public UserBuilder $user;
    public ChecklistGroupBuilder $checklistGroup;
    public ChecklistBuilder $checklist;
    public TaskBuilder $task;
    public PageBuilder $page;

    private function __construct()
    {
        $this->user           = new UserBuilder();
        $this->checklistGroup = new ChecklistGroupBuilder();
        $this->checklist      = new ChecklistBuilder();
        $this->task           = new TaskBuilder();
        $this->page           = new PageBuilder();
    }

    /**
     * @return ModelBuilderHelper
     */
    public static function getInstance(): ModelBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
