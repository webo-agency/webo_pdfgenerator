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

    public function __construct() {
        parent::__construct();
        $this->name = "webo_pdfgenerator";
        $this->pdfvariable = $this->context->smarty->assign(array(
			'action' => Tools::getAllValues(),
            'assets' => $this->module->getPathUri()
		));
    }

    public function setMedia()
    {
        parent::setMedia();
        $this->addCSS($this->module->getPathUri().'views/css/font.css');
        $this->addCSS($this->module->getPathUri().'views/css/font.css');
    }

    public function initContent(){
        parent::initContent();
        if(Tools::getValue('action') == "getpdffromwebsite" && Tools::getValue("pdfnamefile") && Tools::getValue("templatelocation"))
        {

         if(Tools::getValue('templatelocation')){
          $location = "module:webo_pdfgenerator/views/templates/displayPdfGenerator.tpl";
         }

            $this->setTemplate( $location );
            $html = $this->context->smarty->fetch($location);

            $this->generatePdfFile(Tools::getAllValues(), $html);
        }
    }

    public function generatePdfFile(array $variable, $html)
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $options->setisHtml5ParserEnabled(true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
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