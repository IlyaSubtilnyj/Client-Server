<?php
declare(strict_types = 1);

namespace Application\Command;
use Domain\Model\ValueObject\TaskStatus;

class UpdateTaskCommand
{

    private ?int $task_id               = null;
    private ?string $title              = null;
    private ?string $description        = null;
    private ?\DateTime $complete_date   = null;
    private ?TaskStatus $status         = null;

    public function __construct(
        int $task_id,
        string $title,
        ?string $description,
        ?\DateTime $complete_date,
        TaskStatus $status
    )
    {
        $this->task_id       = $task_id;
        $this->title         = $title;
        $this->description   = $description;
        $this->complete_date = $complete_date;
        $this->status        = $status;
    }

    public function getTaskId(): ?int {
        return $this->task_id;
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