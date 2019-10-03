<?php


namespace controller;

use Exception;

/**
 * Class HomeController
 * @package controller
 */
class HomeController extends AbstractController
{
    /**
     * Homepage
     * @return string
     * @throws Exception
     */
    public function welcome(): string
    {
        return $this->view('homepage');
    }

    /**
     * Not found page
     * @return string
     * @throws Exception
     */
    public function notFound(): string
    {
        return $this->view('404');
    }
}
