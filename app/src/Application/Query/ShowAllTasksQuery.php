<?php

namespace Application\Query;

class ShowAllTasksQuery
{
    private ?array $filter = null;
    private $sort;
    private $pagination;

    public function __construct(
        ?array $filter      = null,
        mixed $sort         = null,
        mixed $pagination   = null,
    )
    {
        $this->filter       = $filter;
        $this->sort         = $sort;
        $this->pagination   = $pagination;
    }

    public function getFilter()
    {
        return $this->filter;
    }
}