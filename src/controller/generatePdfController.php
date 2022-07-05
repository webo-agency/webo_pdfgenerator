<?php
namespace Prestashop\Module\WeboPdfgenerator\controller;

use Dompdf\Dompdf;

class generatePdfController
{
    public function getRequestPdf()
    {
        $new = Dompdf();
    }
}