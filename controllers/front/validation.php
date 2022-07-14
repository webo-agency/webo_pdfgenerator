<?php
/**
 * <ModuleClassName> => webo_PdfGenerator
 * <FileName> => validation.php
 * Format expected: <ModuleClassName><FileName>ModuleFrontController
 */
use Dompdf\Dompdf;

class webo_pdfgeneratorvalidationModuleFrontController extends ModuleFrontController
{
    /** $ajax bool */
    public $ajax;

    /** $html string */
    public $html;

    public function __construct() {
        parent::__construct();
        $this->name = "webo_pdfgenerator";
        $this->pdfvariable = $this->context->smarty->assign(array('action' => Tools::getAllValues()));
        $this->html = $this->context->smarty->fetch('module:webo_pdfgenerator/views/templates/displayPdfGenerator.tpl', $this->name);
    }

    public function initContent(){
        if(Tools::getValue('action') == "getpdffromwebsite")
        {
            $this->generatePdfFile(Tools::getAllValues());
        }else {
            Tools::redirect("404");
        }
        parent::initContent();
    }

    public function generatePdfFile(array $variable)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream($variable["pdfnamefile"].'.pdf');
        $dompdf->output(array('abc'=>'cba'));
        if(!$dompdf->stream($variable["pdfnamefile"].'.pdf'))
        {
            $this->ajaxRender(json_encode([
                'success' => false,
                'code' => '200',
                'data' => "We cant't create pdf file"
            ]));
        }
    }

}