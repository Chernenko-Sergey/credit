<?php

namespace CreditBundle\Services;

/**
 * Get accurate time during each script execution.
 * It serves for nothing in this bundle for the moment, but could be useful in the future.
 */
final class CurrentTime
{
    static private $time;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
    }

    public static function getTime()
    {
        if (empty(self::$time)) {
            self::$time = new \DateTime();
        }

        return clone self::$time;
    }
}
