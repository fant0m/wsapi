<?php
namespace core;


use Exception;

/**
 * Class Form
 * @package core
 */
class Form
{
    private $method;
    private $action;

    private $state;
    private $fields;

    public const STATE_VALID = 1;
    public const STATE_INVALID = 0;

    public function __construct(string $method, string $action = null)
    {
        $this->method = $method;
        $this->action = $action;

        $this->state = self::STATE_VALID;
        $this->fields = [];
    }

    /**
     * Add new field to form
     * @param string $class
     * @param string $name
     * @param string $title
     * @param string $value
     * @param array $data
     */
    public function addField(string $class, string $name, string $title, string $value, array $data = []): void
    {
        $this->fields[] = new $class($name, $title, $value, $data);
    }

    /**
     * Validate all form fields
     * @param array $data
     */
    public function validate(array $data): void
    {
        $this->state = self::STATE_VALID;

        foreach ($this->fields as $field)
        {
            // set posted data to model
            if (array_key_exists($field->getName(), $data)) {
                $escape = htmlentities($data[$field->getName()], ENT_QUOTES, 'UTF-8');
                $field->setValue($escape);
            }

            // validate field
            $result = $field->validate();
            if ($result == Validator::RESULT_ERROR) {
                $this->state = self::STATE_INVALID;
            }
        }
    }

    /**
     * Get single form field
     * @param string $name
     * @return FormItem
     * @throws Exception
     */
    public function getField(string $name): FormItem
    {
        if (!array_key_exists($name, $this->fields)) {
            throw new Exception('Invalid field name!');
        }

        return $this->fields[$name];
    }

    /**
     * Get all form fields
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Get key-value field values
     * @return array
     */
    public function getData(): array
    {
        $data = [];

        foreach ($this->fields as $field) {
            if (!empty($field->getValue())) {
                $data[$field->getName()] = $field->getValue();
            }
        }

        return $data;
    }

    /**
     * Form open HTML helper
     * @return string
     */
    public function open(): string
    {
        $html = '<form method="' . $this->method . '"';

        if ($this->action)
        {
            $html .= ' action="' . $this->action . '""';
        }

        $html .= '>';

        return $html;
    }

    /**
     * Form close HTML helper
     * @return string
     */
    public function close(): string
    {
        return '</form>';
    }

    /**
     * Check if form state is valid
     * @return string
     */
    public function isValid(): string
    {
        return $this->state == self::STATE_VALID;
    }
}
