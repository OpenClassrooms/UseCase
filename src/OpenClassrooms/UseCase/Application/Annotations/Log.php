<?php

namespace OpenClassrooms\UseCase\Application\Annotations;

use Psr\Log\LogLevel;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 * @Annotation
 * @deprecated
 */
class Log
{
    const PRE_METHOD = 'pre';

    const POST_METHOD = 'post';

    const ON_EXCEPTION_METHOD = 'onException';

    const DEFAULT_METHOD = self::ON_EXCEPTION_METHOD;

    const DEFAULT_LEVEL = LogLevel::WARNING;

    /**
     * @var string[]
     */
    private static $allowedMethods = array(
        self::PRE_METHOD,
        self::POST_METHOD,
        self::ON_EXCEPTION_METHOD,
    );

    /**
     * @var string[]
     */
    private static $allowedLevels = array(
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::DEBUG,
        LogLevel::EMERGENCY,
        LogLevel::ERROR,
        LogLevel::INFO,
        LogLevel::NOTICE,
        LogLevel::WARNING,
    );

    /**
     * @var string
     */
    public $level = self::DEFAULT_LEVEL;

    /**
     * @var string
     */
    public $message;

    /**
     * @var array
     */
    public $context = array();

    /**
     * @var string[]
     */
    public $methods = array(self::DEFAULT_METHOD);

    public function __construct(array $values)
    {
        if (isset($values['level'])) {
            $this->level = $values['level'];
            if (!in_array($this->level, self::$allowedLevels)) {
                throw new \InvalidArgumentException(
                    'Level "'.$this->level.'" is not a valid PSR level. See Psr\Log\LogLevel.'
                );
            }
        }

        if (isset($values['methods'])) {
            $this->methods = is_array($values['methods']) ? $values['methods'] :
                array_map('trim', explode(',', $values['methods']));
        }

        foreach ($this->methods as $method) {
            if (!in_array($method, self::$allowedMethods)) {
                throw new \InvalidArgumentException(
                    'Method "'.$method.'" is not allowed. Allowed: pre, post and onException'
                );
            }
        }

        if (isset($values['message'])) {
            $this->message = $values['message'];
        }

        if (isset($values['context'])) {
            if (is_array($values['context'])) {
                $this->context = $values['context'];
            }
        }
    }

    /**
     * @return string[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return array
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
