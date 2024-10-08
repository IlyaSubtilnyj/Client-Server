<?php

namespace Application\Service;
use Domain\Model\Entity\Task;
use Domain\Model\ValueObject\TaskStatus;

final class TaskCollectionService
{
    /**
     * @var array<Task>|null
     */
    private ?array $__tasks = null;

    /**
     * @return array<Task>|null
     */
    public function _(): ?array
    {
        $res = $this->__tasks;
        $this->__tasks = null;
        return $res;
    }

    /**
     * @param array<Task> $tasks
     * @return self
     */
    public function for(array $tasks): self
    {
        $this->__tasks = $tasks;
        return $this;
    }

    /**
     * @param array<string, TaskStatus> $map
     * @return self
     */
    public function filter(array $map): self
    {
        $this->__tasks = array_filter($this->__tasks, function($task) use ($map) {
            $res = true;
            array_walk($map, function($value, $key) use ($task, &$res) {
                $res = $res & ($task[$key] === $value);
            });
            return $res;
        });
        return $this;
    }
}