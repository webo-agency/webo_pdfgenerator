<?php
namespace Prestashop\Module\WeboPdfgenerator\controller;

use Dompdf\Dompdf;

class generatePdfController
{
    public function getRequestPdf()
    {
        $link = new Link;
        $parameters = array("action" => "action_name");
        $ajax_link = $link->getModuleLink('webo_PdfGenerator','controller', $parameters);

        Media::addJsDef(array(
            "ajax_link" => $ajax_link
        ));
    }
}