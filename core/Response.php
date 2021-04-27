<?php


namespace app\core;

/**
 * Class Response
 * @package app\core
 */
class Response
{
    public function setStatusCode(string $code)
    {
        if (is_numeric($code)) http_response_code($code);
    }

    public function redirect(string $url)
    {
        header("Location: $url");
    }
}