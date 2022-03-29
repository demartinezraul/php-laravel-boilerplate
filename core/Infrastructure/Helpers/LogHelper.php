<?php

namespace Core\Infrastructure\Helpers;

use Illuminate\Support\Facades\Log as LogFacade;
use hisorange\BrowserDetect\Facade as BrowserDetect;
use Throwable;

class LogHelper
{
    private static string $message;
    private static Throwable $exception;
    private static array $data;
    private static bool $showStacktrace;

    public static function log(
        array $data = null,
        Throwable $exception = null,
        bool $showStacktrace = false,
        string $arquivo = '',
        string $class = '',
        string $method = '',
        string $line = ''
    ): void {
        self::$message = '';
        self::$data = $data;
        self::$showStacktrace = $showStacktrace;

        if (!empty($exception)) {
            self::$exception = $exception;
            self::formatExceptionLog($exception);
        }

        if (!empty($data) && empty($exception)) {
            self::formatInformedData($arquivo, $class, $method, $line);
        }

        self::formatLogWithUserInformation();
        self::setLogLevel();
    }

    private static function formatExceptionLog(): void
    {
        self::$message .= 'Exceção registrada no arquivo "' . self::$exception->getFile() . '", ';
        self::$message .= 'na linha "' . self::$exception->getLine() . '", ';
        self::$message .= 'mensagem: "' . self::$exception->getMessage() . '", ';
    }

    private static function formatInformedData(string $arquivo, string $class, string $method, string $line): void
    {
        $arquivo = $arquivo ?: __FILE__;
        $class = $class ?: __CLASS__;
        $method = $method ?: __METHOD__;
        $method = explode('::', $method);
        $method = $method[1];
        $line = $line ?: __LINE__;

        self::$message .= 'data capturado no arquivo "' . $arquivo . '", ';
        self::$message .= 'na classe "' . $class . '", ';
        self::$message .= 'no metodo "' . $method . '", ';
        self::$message .= 'na linha "' . $line . '", ';
    }

    public static function formatLogWithUserInformation(): void
    {

        self::$message .= 'IP de origem "' . request()->ip() ?? ' ' . '", ';
        self::$message .= 'navegador utilizado "' . BrowserDetect::browserName() . '", ';
        self::$message .= 'sistema operacional "' . BrowserDetect::platformName() . '", ';
        self::$message .= self::$data != null ? 'informações do reigistro: "' . json_encode(self::$data) . '"' : '';

        if (self::$showStacktrace) {
            self::$message .= ', pilha de rastreamento: "' . self::$exception->getTraceAsString() . '"';
        }
    }

    public static function setLogLevel(): void
    {
        if (!empty(self::$exception)) {
            LogFacade::channel(env('LOG_CHANNEL'))->error(self::$message);
        } else {
            LogFacade::debug(self::$message);
        }
    }

    public static function getFormatedLogMessage(): string
    {
        return self::$message;
    }
}
