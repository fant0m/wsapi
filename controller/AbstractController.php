<?php
namespace controller;

use core\Flashable;
use core\View;
use Exception;

/**
 * Class AbstractController
 * @package controller
 */
abstract class AbstractController
{
    use Flashable;

    /**
     * Render view
     * @param string $view
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function view(string $view, array $data = []): string
    {
        $data['messages'] = $this->flush();

        $view = new View($view, $data);
        return $view->render();
    }

    /**
     * Redirect to action
     * @param string $action
     * @param array $data
     */
    public function redirect(string $action, array $data = []): void
    {
        $data['action'] = $action;
        $query = http_build_query($data);
        header('Location: ?' . $query);
        exit;
    }

    /**
     * Escape parameters
     * @param string $text
     * @return string
     */
    public function escape(string $text): string
    {
        return htmlentities($text, ENT_QUOTES, 'UTF-8');
    }
}
