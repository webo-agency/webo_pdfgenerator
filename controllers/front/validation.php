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
             'background' => $this->encodeBase64ImagePath(_PS_MODULE_DIR_ . $this->name . '/views/img/background.svg')
		));
    }

    public function encodeBase64ImagePath($path)
    {
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = $this->fillData($data);
		return 'data:image/svg+xml;charset=utf-8;base64,'. base64_encode($data);
	}

    public function fillData($data){
		$valueFromCustomer = Tools::getAllValues();
		$newData = $data;

		$newData = str_replace("%title_1%", $valueFromCustomer['title'], $newData);
		$newData = str_replace("%title_2%", $valueFromCustomer['title'], $newData);
		$newData = str_replace("%title_3%", $valueFromCustomer['title'], $newData);

		$newData = str_replace("%x_value%", $valueFromCustomer['width'] . 'cm', $newData);
		$newData = str_replace("%y_value%", $valueFromCustomer['height'] . 'cm', $newData);

		$newData = str_replace("%kolorystyka_title%", 'Kolorystyka', $newData);
		$newData = str_replace("%kolorystyka_value%", $valueFromCustomer['color'], $newData);

		$newData = str_replace("%rozmiar_title%", 'Rozmiar', $newData);
		$newData = str_replace("%rozmiar_value%", $valueFromCustomer['size'], $newData);

		$newData = str_replace("%standard_title%", 'Standard', $newData);
		$newData = str_replace("%standard_value%", $valueFromCustomer['standard'], $newData);

		$newData = str_replace("%tekstura_title%", 'Tekstura', $newData);
		$newData = str_replace("%tekstura_value%", $valueFromCustomer['texture'], $newData);

		$newData = str_replace("%image%", "black", $newData);

		return $newData;
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