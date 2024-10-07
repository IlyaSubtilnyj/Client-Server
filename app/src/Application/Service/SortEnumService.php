<?php

namespace Application\Service;

enum SortEnumService: int {
    case ASC    = 1;
    case DESC   = 2;

    public function compare(mixed $a, mixed $b): bool {
        return match($this) {
            self::ASC   => $a > $b,
            self::DESC  => $a < $b,
        };
    }
}