<?php

namespace Application\Query;

class ShowTaskQuery
{

    private ?string $title = null;

    public function __construct(
        string $title,
    )
    {
        $this->title = $title;
    }

    public function getTitle(): ?string {
        return $this->title;
    }
}