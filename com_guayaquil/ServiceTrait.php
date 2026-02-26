<?php

namespace guayaquil;

use GuayaquilLib\Command;
use GuayaquilLib\objects\BaseObject;

trait ServiceTrait
{
    public function executeCommand(Command $command): BaseObject
    {
        $timeStart = microtime(true);

        try {
            $response = $this->request($command);
            if ($this->view) {
                $this->view->appendLastResponse((string)$response->getBody());
            }
            return $this->normalizeResponse($command, $response);
        } finally {
            $timeEnd = microtime(true);
            if ($this->view) {
                $this->view->setLastExecutionTime($timeEnd - $timeStart);
                $this->view->appendLastExecutionCommand([$command->getRequestUrl()]);
            }
        }

        return $result;
    }

    public function executeCommands($commands, array $headers = []): array
    {
        $timeStart = microtime(true);

        try {
            if (is_array($commands)) {
                $responses = $this->requestMulti($commands);
                $result = [];

                foreach ($responses as $index => $response) {
                    $result[$index] = $this->normalizeResponse($commands[$index], $response);
                    if ($this->view) {
                        $this->view->appendLastResponse((string)$response->getBody());
                    }
                }

                return $result;
            }
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

        return $result;
    }
}