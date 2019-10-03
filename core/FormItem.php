<?php


namespace core;

/**
 * Class FormItem
 * @package core
 */
abstract class FormItem
{
    private $name;
    private $title;
    private $value;
    private $data;

    /**
     * FormItem constructor.
     * @param string $name
     * @param string $title
     * @param string $value
     * @param array $data
     */
    public function __construct(string $name, string $title, string $value, array $data = [])
    {
        $this->name = $name;
        $this->title = $title;
        $this->value = $value;
        $this->data = $data;
    }

    /**
     * Check if value passes set rules
     * @return mixed
     */
    public function validate()
    {
        unset($this->data['errors']);

        $validator = new Validator($this->data['rules'] ?? [], $this->value);
        $result = $validator->check();

        if ($result['status'] == Validator::RESULT_ERROR) {
            $this->data['errors'] = $result['errors'];
        }

        return $result['status'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function isInvalid(): bool
    {
        return isset($this->data['errors']);
    }

    /**
     * Render as HTML
     * @return string
     */
    public abstract function render(): string;
}
