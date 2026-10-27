<?php

namespace guayaquil\views\catalogs;

use guayaquil\Config;
use guayaquil\View;

class CatalogsHtml extends View
{
    /**
     * @var string
     */
    public $frameExample;

    /**
     * @var string
     */
    public $vinExample;

    /**
     * @var array
     */
    public $catalogs;

    /**
     * @var int
     */
    public $columns;

    /**
     * @var float
     */
    public $elemInRow;

    /**
     * @var int
     */
    public $elemCount;

    /**
     * @var int
     */
    public $rest;

    /**
     * @var string
     */
    public $oemExample;

    public function Display($tpl = 'catalogs', $view = 'view')
    {
        $catalogs = $this->getOemService()->listCatalogs();
        $examples = $catalogs->getExamples();
        if (!is_array($examples)) {
            $examples = [];
        }

        $columns = (int)$this->config->catalogColumns;
        if ($columns < 1) {
            $columns = 1;
        }
        $elemCount = count($catalogs->getCatalogs() ?: []);
        $elemInRow = floor($elemCount / $columns);
        $rest = $elemCount % $columns;

        $this->frameExample = isset($examples[1]) ? $examples[1] : '';
        $this->vinExample = isset($examples[0]) ? $examples[0] : '';
        $this->catalogs = $catalogs->getCatalogs();
        $this->columns = $columns;
        $this->elemInRow = $elemInRow;
        $this->elemCount = $elemCount;
        $this->rest = $rest;
        $this->oemExample = !empty($this->config->oemExample) ? $this->config->oemExample : '0913128000';

        parent::Display($tpl, $view);
    }
}




