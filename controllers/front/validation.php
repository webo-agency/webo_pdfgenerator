<?php
/**
 * <ModuleClassName> => webo_PdfGenerator
 * <FileName> => validation.php
 * Format expected: <ModuleClassName><FileName>ModuleFrontController
 */

use Dompdf\Dompdf;
use Dompdf\Options;

class webo_pdfgeneratorvalidationModuleFrontController extends ModuleFrontController
{
    /** $ajax bool */
    public $ajax;

    /** $html string */
    public $html;

    public function __construct() {
        parent::__construct();
        $this->name = "webo_pdfgenerator";
        $this->pdfvariable = $this->context->smarty->assign(array('action' => Tools::getAllValues(), 'base_url' => _PS_BASE_URL_));
        $this->html = $this->context->smarty->fetch('module:webo_pdfgenerator/views/templates/displayPdfGenerator.tpl');
    }

    public function setMedia()
    {
        parent::setMedia();
        $this->addCSS($this->module->getPathUri().'views/css/font.css');
    }

    public function initContent(){
//        $this->setTemplate('module:webo_pdfgenerator/views/templates/displayPdfGenerator.tpl');
        if(Tools::getValue('action') == "getpdffromwebsite")
        {
            $this->generatePdfFile(Tools::getAllValues(), $this->setTemplate('module:webo_pdfgenerator/views/templates/displayPdfGenerator.tpl'));
        }else {
            Tools::redirect("404");
        }
        parent::initContent();
    }

    public function generatePdfFile(array $variable, $abc)
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $options->setisHtml5ParserEnabled(true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($this->html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream($variable["pdfnamefile"].'.pdf');
        $dompdf->output();
        if($dompdf->stream($variable["pdfnamefile"].'.pdf', ['Attachment' => false]))
        {
            $this->ajaxRender(json_encode([
                'success' => false,
                'code' => '200',
                'data' => "We can't create pdf file"
            ]));
        }
    }

}