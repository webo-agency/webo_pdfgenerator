<?php

require_once _PS_MODULE_DIR_.'webo_pdfgenerator/webo_pdfgenerator.php';

class Webo_PdfGeneratorAjaxModuleFrontController extends ModuleFrontController
{

    /**
     * @var bool
     *
     */
    public $ssl = true;

    /**
     * @see FrontController::initContent()
     *
     * @return void
     */
    public function initContent()
    {
        parent::initContent();
        ob_end_clean();
        header('Content-Type: application/json');
        exit(json_encode([
            'test' => 'ok'
        ]));
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        parent::init();
    }
}