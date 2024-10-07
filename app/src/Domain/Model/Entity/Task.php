<?php

namespace Domain\Model\Entity;

use Domain\Model\ValueObject\TaskStatus;

class Task implements \ArrayAccess
{
    private static $db;
    public ?int         $id             = null;
    public ?string      $title          = null;
    public ?string      $description    = null;
    public ?\DateTime   $completeDate   = null;
    public ?TaskStatus  $status         = null;

    public function __construct($title, $description, $complete_date, $status)
    {
        $this->title            = $title;
        $this->description      = $description;
        $this->completeDate     = $complete_date;
        $this->status           = $status;
    }

    public static function setDatabase($database) {
        self::$db = $database;
    }

    public static function all(): array {

        $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/uploads/tasks';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
            return [];
        }

        if(is_file($uploadDir.'/tasks.txt')) {

            return unserialize(file_get_contents($uploadDir.'/tasks.txt')); 
        } else {

            file_put_contents($uploadDir.'/tasks.txt', serialize([]));
            return [];
        }
    }

    public static function find(int $id): ?Task
    {
        $tasks = self::all();

        $key = array_search($id, array_column($tasks, 'id'));

        if($key === false) {

            return null;
        }

        return $tasks[$key];
    }

    public static function findByTitle(string $title): ?Task
    {
        
        $tasks = self::all();

        $key = array_search($title, array_column($tasks, 'title'));

        if($key === false) {

            return null;
        }

        return $tasks[$key];
    }

    public static function nextId(): int
    {
        $tasks = self::all();

        if(empty($tasks)) {

            return 1;
        } else {

            return end($tasks)['id'] + 1;
        }
    }

    public function save(): void
    {
        $this->id = self::nextId();
        $tasks = self::all();
        $tasks[] = $this;

        $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/uploads/tasks';
        file_put_contents($uploadDir.'/tasks.txt', serialize($tasks));
    }

    public function update(): void
    {
        $tasks = self::all();
        
        $key = array_search($this->id, array_column($tasks, 'id'));
        $tasks[$key] = $this;

        $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/uploads/tasks';
        file_put_contents($uploadDir.'/tasks.txt', serialize($tasks));
    }

    public function offsetSet($offset, $value): void {
        
        $this->{$offset} = $value;
    }

    public function offsetExists($offset): bool {
        return isset($this->{$offset});
    }

    public function offsetUnset($offset): void {
        $this->{$offset} = null;
    }

    public function offsetGet($offset): mixed {
        return isset($this->{$offset}) ? $this->{$offset} : null;
    }
}