<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class LoggerSpy implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @var string[]
     */
    public static $level;

    /**
     * @var string
     */
    public static $message;

    /**
     * @var array
     */
    public static $context = array();

    public function __construct()
    {
        self::$context = array();
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        self::$level[] = $level;
        self::$message[] = $message;
        self::$context[] = $context;

        return null;
    }
}
