<?php

/**
 * Created by Kayac Ha Noi.
 * User: ManNV
 * Date: 11/1/2016
 * Time: 9:43 AM
 */
namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerServiceProvider
{
    /**
     * @var \Monolog\Logger
     */
    private $_logger;

    private $_controller = '';
    private $_method = '';
    private $_line = 0;
    private $_fileName = '';
    private $_classIndex = 3;

    /**
     * LoggerService constructor.
     * @param string $fileName
     * VD: userlog
     */
    public function __construct($fileName = '')
    {
        if($fileName == '') {
            $fileName = env('LOGGER_VERSION', 'v1');
        }
        $this->_fileName = $fileName;
    }

    public function setClassIndex($index = 3) {
        $this->_classIndex = $index;
    }

    private function initLogger()
    {
        $trace = debug_backtrace();
        $this->_line = isset($trace[$this->_classIndex - 1]['line']) ? $trace[$this->_classIndex - 1]['line'] : '0';
        $this->_method = isset($trace[$this->_classIndex]['function']) ? $trace[$this->_classIndex]['function'] : '';
        $className = isset($trace[$this->_classIndex]['class']) ? $trace[$this->_classIndex]['class'] : '';

        $arr = explode('\\', $className);
        if (count($arr) > 1) {
            $this->_controller = array_pop($arr);
        } else {
            $this->_controller = $className;
        }
        $this->_controller = str_replace('Controller', '', $this->_controller);

        $loggerPath = storage_path('logs') . '/' . $this->_fileName . '.log';
        $this->_logger = new Logger($this->_controller);
        $handler = new StreamHandler($loggerPath, env('APP_LOG_LEVEL', 'debug'));
        $handler->setFormatter(new LineFormatter(null, null, true, true));
        $this->_logger->pushHandler($handler);
        $this->_logger->pushHandler(new FirePHPHandler());
    }

    /**
     * @param $context
     */
    private function addClassInfo(&$message = '', &$context = array())
    {
        $context = json_decode(json_encode($context), true);
        $message = '[' . $this->_method . ':' . $this->_line . ':' . $_SERVER['REQUEST_METHOD'] . '] -> ' . $message . "\n";
    }

    /**
     * @param string $message
     * @param $context
     */
    public function debug($message = '', $context = array())
    {
        $this->initLogger();
        $this->addClassInfo($message, $context);
        $this->_logger->debug($message, $context);
    }

    /**
     * @param string $message
     * @param $context
     */
    public function error($message = '', $context = array())
    {
        $this->initLogger();
        $this->addClassInfo($message, $context);
        $this->_logger->error($message, $context);
    }
}