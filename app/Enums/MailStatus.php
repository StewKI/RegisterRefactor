<?php

namespace App\Enums;

enum MailStatus: int
{
    case QUEUED = 0;
    case SENT = 1;
    case FAILED = 2;
}
