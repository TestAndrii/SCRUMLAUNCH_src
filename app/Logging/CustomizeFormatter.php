<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;
use Illuminate\Log\Logger;

class CustomizeFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param Logger $logger
     */
    public function __invoke(Logger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter(
                "[%datetime%] %channel%.%level_name%: %message%\n"
            ));
//        "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
        }
    }
}
