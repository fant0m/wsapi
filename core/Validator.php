<?php


namespace core;

/**
 * Class Validator
 * @package core
 */
class Validator
{
    private $errors;
    private $rules;
    private $value;

    public const RESULT_OK = 1;
    public const RESULT_ERROR = 2;

    public function __construct(array $rules, $value)
    {
        $this->rules = $rules;
        $this->value = $value;
    }

    /**
     * Check if value is not empty
     */
    private function checkRequired(): void
    {
        if (empty($this->value)) {
            $this->errors[] = 'Field is required!';
        }
    }

    /**
     * Check if value has minimum length
     * @param $length
     */
    private function checkMinLength($length): void
    {
        if (strlen($this->value) < $length) {
            $this->errors[] = 'Minimum required length is ' . $length . '!';
        }
    }

    /**
     * Check if value is integer
     */
    private function checkInteger(): void
    {
        if (!empty($this->value) && !is_numeric($this->value)) {
            $this->errors[] = 'The value must be an integer!';
        }
    }

    /**
     * Check if value passes required rules
     * @return array
     */
    public function check(): array  {
        $this->errors = [];

        foreach ($this->rules as $rule) {
            $parse = explode(':', $rule);
            switch ($parse[0]) {
                case 'required':
                    $this->checkRequired();
                    break;
                case 'minlength':
                    $this->checkMinLength($parse[1]);
                    break;
                case 'integer':
                    $this->checkInteger();
                    break;
                default:
                    break;
            }
        }

        return [
            'errors' => $this->errors,
            'status' => count($this->errors) > 0 ? self::RESULT_ERROR : self::RESULT_OK
        ];
    }
}
