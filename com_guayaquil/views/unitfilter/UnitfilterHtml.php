<?php

namespace guayaquil\views\unitfilter;

use guayaquil\View;
use GuayaquilLib\objects\oem\FilterObject;
use GuayaquilLib\objects\oem\UnitObject;
use GuayaquilLib\Oem;

class UnitfilterHtml extends View
{
    /**
     * @var FilterObject
     */
    public $filter_data;

    /**
     * @var UnitObject
     */
    public $unit;

    /**
     * @var array
     */
    public $from;

    /**
     * @var string
     */
    public $fromTask;

    public function Display($tpl = 'unitfilter', $view = 'view')
    {
        $catalogCode = $this->input->getString('c');
        $ssd = $this->input->getString('ssd');
        $f = $this->input->getString('f');
        $vid = $this->input->getString('vid');
        $uid = $this->input->getString('uid');

        list($filters, $unit) = $this->getOemService()->queryButch([
            Oem::getFilterByUnit($catalogCode, $vid, $ssd, $uid, $f, $this->getLanguage()->getLocalization()),
            Oem::getUnitInfo($catalogCode, $ssd, $uid, $this->getLanguage()->getLocalization()),
        ]);

        $this->filter_data = $filters;
        $this->unit = $unit;
        $this->from = $this->input->getArray();
        $this->fromTask = $this->input->getString('fromTask');

        parent::Display($tpl, $view);
    }
}