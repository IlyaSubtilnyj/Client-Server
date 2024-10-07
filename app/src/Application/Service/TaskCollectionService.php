<?php

namespace Application\Service;

class TaskCollectionService
{

    private ?array $__tasks = null;

    public function _(): ?array
    {
        $res = $this->__tasks;
        $this->__tasks = null;
        return $res;
    }

    public function for(array $tasks): static
    {
        $this->__tasks = $tasks;
        return $this;
    }

    public function filter(array $map): static
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

    public function sort() {}
    public function paginate() {}
}