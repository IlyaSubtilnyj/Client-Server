<?php
declare(strict_types = 1);

namespace Application\Command;
use Domain\Model\ValueObject\TaskStatus;

class StoreTaskCommand
{

    private ?string $title              = null;
    private ?string $description        = null;
    private ?\DateTime $complete_date   = null;
    private ?TaskStatus $status         = null;

    public function __construct(
        string $title,
        ?string $description,
        ?\DateTime $complete_date,
        TaskStatus $status
    )
    {
        $this->title         = $title;
        $this->description   = $description;
        $this->complete_date = $complete_date;
        $this->status        = $status;
    }
    
    public function getTitle(): ?string {
        return $this->title;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getCompleteDate(): ?\DateTime {
        return $this->complete_date;
    }

    public function getStatus(): ?TaskStatus {
        return $this->status;
    }
}