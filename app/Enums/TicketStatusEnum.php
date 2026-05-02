<?php

namespace App\Enums;

enum TicketStatusEnum : string
{
    case Queued     = 'queued';
    case Processing = 'processing';
    case Processed  = 'processed';
    case Failed     = 'failed';
}
