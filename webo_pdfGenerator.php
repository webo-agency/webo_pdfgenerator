<?php

if(!defined('_PS_VERSION_')){
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class webo_PdfGenerator extends Module implements WidgetInterface
{
    public function __construct()
    {
        $this->name = "webo_pdfgenerator";
        $this->tab = "others";
        $this->author = "Webo.Agency";
        $this->bootstrap = true;
        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
        $this->displayName = $this->trans('Webo PDF Generator', array(), 'Modules.webo_PdfGenerator');
        $this->description = $this->trans('Module generate pdf file');
        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', array(), 'Modules.webo_PdfGenerator');
        parent::__construct();
    }

    public function install()
    {
        return parent::install();
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function renderWidget($hookName, array $configuration)
    {

        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        try {
            return $this->fetch('module:'. $this->name.'/views/templates/hook/displayPdfGenerator.tpl');
        } catch (Exception $e)
        {
            if(strpos($e->getMessage(), 'displayPdfGenerator.tpl') !== false)
            {
                return $this->fetch('module:'. $this->name.'/views/templates/hook/displayPdfGenerator.tpl');
            }
        }
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        return [

        ];
    }
}