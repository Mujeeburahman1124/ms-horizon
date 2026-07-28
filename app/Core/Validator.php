<?php
namespace App\Core;

/**
 * Enterprise Data Validation Engine
 */
class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
            $ruleList = is_string($fieldRules) ? explode('|', $fieldRules) : $fieldRules;

            foreach ($ruleList as $rule) {
                if ($rule === 'required' && (empty($value) && $value !== '0')) {
                    $this->errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
                } elseif ($rule === 'email' && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field][] = 'Please provide a valid email address.';
                } elseif (str_starts_with($rule, 'min:')) {
                    $min = (int) explode(':', $rule)[1];
                    if (!empty($value) && strlen($value) < $min) {
                        $this->errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . " must be at least {$min} characters.";
                    }
                } elseif (str_starts_with($rule, 'max:')) {
                    $max = (int) explode(':', $rule)[1];
                    if (!empty($value) && strlen($value) > $max) {
                        $this->errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . " must not exceed {$max} characters.";
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstError(): ?string
    {
        foreach ($this->errors as $fieldErrors) {
            return $fieldErrors[0] ?? null;
        }
        return null;
    }
}
