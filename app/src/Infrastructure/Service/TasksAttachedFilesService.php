<?php

namespace Infrastructure\Service;

use Domain\Model\Entity\Task;

class TasksAttachedFilesService
{
    private string $__uploadDir = 'uploads/files';

    /**
     * @param \Domain\Model\Entity\Task $task
     * @param array<string, mixed> $files
     * @return void
     */
    public function attachFiles(Task $task, array $files): void
    {

        $uploadDir = $this->uploadDir();

        if (!is_dir($uploadDir)) {

            mkdir($uploadDir, 0755, true);
        }
        
        for($i = 0; $i < count($files['name']); $i++) {

            if ($files['error'][$i] === UPLOAD_ERR_OK) {

                $fileName       = $task->id . '_' . basename($files['name'][$i]);
                $targetFilePath = implode(DIRECTORY_SEPARATOR, [$uploadDir, $fileName]);
                
                move_uploaded_file($files['tmp_name'][$i], $targetFilePath);
            }
        }
    }

    private function uploadDir(): string {

        return implode(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], $this->__uploadDir]);
    }
}
