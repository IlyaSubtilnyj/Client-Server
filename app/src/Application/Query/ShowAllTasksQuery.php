<?php

namespace Application\Query;

use Domain\Model\ValueObject\TaskStatus;

class ShowAllTasksQuery
{
    /**
     * @var array<string, TaskStatus>
     */
    private ?array $filter = null;

    /**
     * @param array<string, TaskStatus> $filter
     */
    public function __construct(
        ?array $filter,
    )
    {
        $this->filter       = $filter;
    }

    /**
     * @return array<string, TaskStatus>|null
     */
    public function getFilter(): array|null
    {
        return $this->filter;
    }
}