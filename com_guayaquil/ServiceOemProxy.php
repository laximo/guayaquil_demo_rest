<?php

namespace guayaquil;

use GuayaquilLib\Command;
use GuayaquilLib\objects\BaseObject;
use GuayaquilLib\ServiceOem;

class ServiceOemProxy extends ServiceOem
{
    /**
     * @var View
     */
    private $view;

    public function __construct($view, string $login, string $password, string $serviceUrl)
    {
        parent::__construct($login, $password, $serviceUrl);
        $this->view = $view;
    }

    public function executeCommand(Command $command): BaseObject
    {
        $timeStart = microtime(true);

        try {
            $result = parent::executeCommand($command);
        } finally {
            $timeEnd = microtime(true);
            if ($this->view) {
                $this->view->setLastExecutionTime($timeEnd - $timeStart);
                $this->view->appendLastExecutionCommand([$command->getCommand()]);
            }
        }

        if ($this->view) {
            $this->view->appendLastResponse(print_r($result, true));
        }

        return $result;
    }

    public function executeCommands($commands, array $headers = []): array
    {
        $timeStart = microtime(true);

        try {
            $result = parent::executeCommands($commands, $headers);
        } finally {
            if ($this->view) {
                $timeEnd = microtime(true);
                $this->view->setLastExecutionTime($timeEnd - $timeStart);

                $commandTexts = [];
                foreach ($commands as $command) {
                    $commandTexts[] = $command->getCommand();
                }

                $this->view->appendLastExecutionCommand($commandTexts);
            }
        }

        if ($this->view) {
            foreach ($result as $response) {
                $this->view->appendLastResponse(print_r($response, true));
            }
        }

        return $result;
    }

    public function queryButch(array $commands): array
    {
        return $this->executeCommands($commands);
    }

}