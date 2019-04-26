<?php

namespace DeltaCMS;

use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;

use Exception;

class Logger extends AbstractLogger
{

    private $file;
    private $exception = "{code} {file}[{line}] {type} {message}\n";
    private $start = "[{logger_logger}]: {logger_time} ";

    private $levels = array(
        'emergency',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug'
    );

    public function __construct($file = "./logs.log")
    {
        if (!file_exists($file)) {
            $ressource = fopen($file, 'w');
            if ($ressource === false) {
                throw new Exception("File at " . $file . " can't be created. exiting", 1);
            }
            fclose($ressource);
        }
        $this->file = $file;
    }

    private function fillMessage($message, $context)
    {
        foreach ($context as $key => $value) {
            $message = preg_replace("/\{$key\}/", $value, $message);
        }
        return $message;
    }

    public function log($level, $message = null, array $context = array())
    {

        if (!in_array($level, $this->levels)) {
            throw new InvalidArgumentException('Level not supported');
        }
        $context["logger_logger"] = ucfirst($level);
        $context["logger_time"] = (new \DateTime())->format("Y-m-d H:i:s");
        if ($message != null) {
            file_put_contents($this->file, $this->fillMessage($this->start . $message . "\n", $context), FILE_APPEND);
        }
        if (isset($context["exception"]) && $context["exception"] instanceof \Exception) {
            $context['code'] = $context["exception"]->getCode();
            $context['file'] = $context["exception"]->getFile();
            $context['line'] = get_class($context["exception"]);
            $context['type'] = $context["exception"]->getCode();
            $context['message'] = $context["exception"]->getMessage();
            file_put_contents($this->file, $this->fillMessage($this->start . $this->exception, $context), FILE_APPEND);
        }
        if ($message === null && !isset($context["exception"])) {
            throw new InvalidArgumentException("Message and Exception not set");
        }
    }
}
