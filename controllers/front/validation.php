<?php
/**
 * <ModuleClassName> => webo_PdfGenerator
 * <FileName> => validation.php
 * Format expected: <ModuleClassName><FileName>ModuleFrontController
 */

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


		$font_data = base64_encode(file_get_contents(_PS_MODULE_DIR_ . $this->name . '/views/fonts/NomadaDidone-LightItalic.ttf'));
		$newData = str_replace("%font_nomada_src%", 'data:font/truetype;charset=utf8;base64,' . $font_data, $newData);

		$font_roboto_light_data = base64_encode(file_get_contents(_PS_MODULE_DIR_ . $this->name . '/views/fonts/Roboto-Light.ttf'));
		$newData = str_replace("%font_roboto_light_src%", 'data:font/truetype;charset=utf8;base64,' . $font_data, $newData);

		$font_roboto_medium_data = base64_encode(file_get_contents(_PS_MODULE_DIR_ . $this->name . '/views/fonts/Roboto-Medium.ttf'));
		$newData = str_replace("%font_roboto_medium_src%", 'data:font/truetype;charset=utf8;base64,' . $font_data, $newData);

		$line_length = 25;
		$txt_line_1 = $this->extractUncutPhrase($valueFromCustomer['title'], $line_length);
		$newData = str_replace("%title_1%", $txt_line_1, $newData);

		$txt_line_2 = str_replace($txt_line_1, '', $valueFromCustomer['title']);
		$txt_line_2 = $this->extractUncutPhrase($txt_line_2, $line_length);
		$newData = str_replace("%title_2%", $txt_line_2, $newData);

		$txt_line_3 = str_replace($txt_line_1, '', str_replace($txt_line_2, '', $valueFromCustomer['title']));
		$txt_line_3 = $this->extractUncutPhrase($txt_line_3, $line_length);
		$newData = str_replace("%title_3%", $txt_line_3, $newData);

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

/**
 * @param string $text
 * @param int $limit
 * @return string
 */
public function extractUncutPhrase($text, $limit)
{
    $delimiters = [',',' '];
    $marks = ['!','?','.'];

    $phrase = substr($text, 0, $limit);
    $nextSymbol = substr($text, $limit, 1);


    // Equal to original
    if ($phrase == $text) {
        return $phrase;
    }
    // If ends with delimiter
    if (in_array($nextSymbol, $delimiters)) {
        return $phrase;
    }
    // If ends with mark
    if (in_array($nextSymbol, $marks)) {
        return $phrase.$nextSymbol;
    }

    $parts = explode(' ', $phrase);
    array_pop($parts);

    return implode(' ', $parts); // Additioanally you may add ' ...' here.
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

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4-L'
]);
$mpdf->WriteHTML($html);
$mpdf->Output();

    }

}