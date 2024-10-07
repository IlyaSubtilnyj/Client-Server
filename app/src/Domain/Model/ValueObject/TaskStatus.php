<?php

namespace Domain\Model\ValueObject;

enum TaskStatus: int
{
    case PENDING    = 1;
    case INWORK     = 2;
    case COMPLETE   = 3;
}