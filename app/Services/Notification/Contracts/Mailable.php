<?php

declare(strict_types=1);

namespace App\Services\Notification\Contracts;

interface Mailable
{
    public function send(): bool;
}
