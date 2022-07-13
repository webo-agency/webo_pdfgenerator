<?php

class webo_pdfgeneratorvalidationModuleFrontController extends FrontController
{
    public $php_self = 'webo_pdfgenerator';

    public function initContent()
    {
        parent::initContent();

    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        $breadcrumb['links'][] = [
            'title' => 'pdf generate',
            'url' => $this->php_self,
            'language' => 'pl'
        ];
        return $breadcrumb;
    }
}