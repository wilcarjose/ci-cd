<?php

namespace Ampliffy\CiCd\Infrastructure;

class Log
{
    public static function debug(string $text) : void
    {
        error_log('--> ' . $text . "\n\n", 3, $_ENV['BASE_PATH'] . 'debug.log');
    }
}
