<?php

namespace guayaquil;

use GuayaquilLib\Command;
use GuayaquilLib\objects\BaseObject;
use GuayaquilLib\ServiceAm;

class ServiceAmProxy extends ServiceAm
{
    use ServiceTrait;

    /**
     * @var View
     */
    private $view;

    public function __construct($view, string $login, string $password, string $serviceUrl)
    {
        parent::__construct($login, $password, $serviceUrl);
        $this->view = $view;
    }

    public function queryButch(array $commands): array
    {
        return $this->executeCommands($commands);
    }
}