<?php

namespace Application\Controller;

use Application\Service\TasksApplicationService;
use League\Plates\Engine;

abstract class AbstractController
{
    private ?Engine $__tmpls = null;
    
    protected ?TasksApplicationService $tasksApplicationService = null;
    
    public function __construct()
    {
        $this->__tmpls                  = new Engine($_SERVER['DOCUMENT_ROOT'].'/templates');
        $this->tasksApplicationService  = new TasksApplicationService;
    }

    /**
     * @param string $name
     * @param array<string, mixed> $data
     * @return string
     */
    protected function render(string $name, array $data = array()): string  
    {
        return $this->__tmpls->render($name, $data);
    }
}