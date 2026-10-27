<?php

namespace guayaquil\modules;


class Input
{
    public function getString($arg, $default = ''): string
    {
        if (!isset($_GET[$arg])) {
            return (string)$default;
        }

        return (string)$_GET[$arg];
    }

    public function getInt($arg, $default = 0): int
    {
        if (!isset($_GET[$arg])) {
            return (int)$default;
        }

        return (int)$_GET[$arg];
    }

    public function get($arg)
    {
        return @$_GET[$arg];
    }

    public function getArray(): array
    {
        return $_GET;
    }

    public function formData(): array
    {
        return $_POST;
    }

}