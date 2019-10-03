<?php


namespace core;

/**
 * Trait Flashable
 * @package core
 */
trait Flashable
{
    /**
    * Add temporary flash notification
    * @param string $type
    * @param string $text
    */
    public function addFlash(string $type, string $text): void
    {
        if (isset($_SESSION['flash_messages'])) {
            $_SESSION['flash_messages'][] = compact('type', 'text');
        } else {
            $_SESSION['flash_messages'] = [];
            $_SESSION['flash_messages'][] = compact('type', 'text');
        }
    }

    /**
     * Return current messages and clear the bag
     * @return array
     */
    public function flush(): array
    {
         $messages = $_SESSION['flash_messages'] ?? [];

         unset($_SESSION['flash_messages']);

         return $messages;
    }
}
