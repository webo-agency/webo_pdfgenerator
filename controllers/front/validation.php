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
        $this->html = $this->context->smarty->fetch('module:webo_pdfgenerator/views/templates/displayPdfGenerator.tpl', $this->name);
    }

    public function initContent(){
//        if(Tools::isSubmit('action'))
//        {
//            return $this->generatePdfFile(Tools::getAllValues());
//        }
        $this->setTemplate(_PS_THEME_DIR_.'templates/errors/404.tpl');
        parent::initContent();
    }

    public function generatePdfFile(array $variable)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        if($dompdf->stream($variable["pdfnamefile"].'.pdf'))
        {
            return true;
        }
        return false;
    }


}