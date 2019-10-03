<?php
namespace core;

use Exception;

/**
 * Class View
 * @package core
 */
class View
{
    private $template;
    private $data;

    /**
     * View constructor.
     * @param string $template
     * @param array $data
     * @throws Exception
     */
    public function __construct(string $template, array $data)
    {
        $path = 'view/' . $template . '.php';
        if (!file_exists($path)) {
            throw new Exception('File not found!');
        }

        $this->template = $path;
        $this->data = $data;
    }

    /**
     * Render template
     * @return string
     */
    public function render(): string {
        $this->data['action'] = Router::getInstance()->getAction();
        $this->data['defaultAction'] = Route::ACTION_DEFAULT;

        extract($this->data);

        ob_start();
        include $this->template;
        return ob_get_clean();
    }
}
