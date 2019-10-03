<?php


namespace core;

/**
 * Class InputField
 * @package core
 */
class InputField extends FormItem
{
    private $type;

    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    private const PREFIX = 'form';


    public function __construct(string $name, string $title, string $value, array $data = [])
    {
        parent::__construct($name, $title, $value, $data);

        $this->type = $data['type'] ?? 'text';
    }

    /**
     * Render field as HTML
     * @return string
     * @todo handle connecting differently
     */
    public function render(): string
    {
        $id = self::PREFIX . '-' . $this->getName();
        $invalid = $this->isInvalid();
        $class = $invalid ? 'form-control is-invalid' : 'form-control';

        $input = '<input type="' . $this->type . '" name="' . $this->getName() . '" id="' . $id . '" class="' . $class . '"';
        if (!empty($this->getValue())) {
            $input .= ' value="' . $this->getValue() . '"';
        }
        $input .= '>';

        $html = '';
        $html .= '<div class="form-group">';
        $html .= '<label for="' . $id . '">' . $this->getTitle() . '</label>';
        $html .= $input;

        if ($invalid) {
            $html .= '<div class="invalid-feedback">';
            $html .= implode('<br>', $this->getData()['errors']);
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }
}
