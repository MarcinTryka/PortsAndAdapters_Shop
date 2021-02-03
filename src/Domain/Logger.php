<?php


namespace Shop\Domain;


use Psr\Log\LoggerInterface;

/**
 * Container to handle logging interface
 * I KNOW THAT SINGLETON IS A KIND OF ANTIPATTERN, but in this small example project it'll be good enough.
 */
class Logger
{
    private static ?Logger $instance = null;
    private LoggerInterface $logger;

    private function __construct()
    {
    }

    public static function getInstance(): Logger
    {
        if (!self::$instance) {
            self::$instance = new Logger();
        }
        return self::$instance;
    }

    public function registerLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * Log debug message
     */
    public function debug(string $message): void
    {
        $this->logger->debug($message);
    }

    /**
     * Log error message
     */
    public function error(string $message): void
    {
        $this->logger->error($message);
    }

    /**
     * Log info message.
     */
    public function info(string $message): void
    {
        $this->logger->info($message);
    }
}