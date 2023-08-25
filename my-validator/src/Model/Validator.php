<?php

namespace Apps\Validator\Model;

use Error;

final class Validator
{
    private array $result;

    public function __construct(private mixed $value)
    {
        $this->result = [];
    }

    public function isEmail(): self
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->includeValidationError('Email not valid');
        }
        // Retornar el mismo objeto permite anidar las sucesivas
        // validaciones, es decir, llamar a otros métodos de
        // esta clase sobre el objeto devuelto
        return $this;
    }

    public function isNumber(): self
    {
        if (!is_numeric($this->value)) {
            $this->includeValidationError('Not a number');
        }

        return $this;
    }

    public function minLength(int $length): self
    {
        if (is_array($this->value)) {
            if (count($this->value) < $length) {
                $this->includeValidationError('Not minimum length');
            }
            // casting de tipos
            // https://www.phptutorial.net/php-tutorial/php-type-casting/
            // https://www.php.net/manual/en/language.types.type-juggling.php
        } else if (strlen((string) $this->value) < $length) {
            $this->includeValidationError('Not minimum length');
        }

        return $this;
    }

    public function isUrl(): self
    {
        if (!filter_var($this->value, FILTER_VALIDATE_URL)) {
            $this->includeValidationError('URL not valid');
        }

        return $this;
    }

    public function contains(array $options): self
    {
        $contains = false;

        if (!is_array($options)) {
            throw new Error('Options is not an array');
        }

        foreach ($options as $option) {
            if (str_contains((string) $this->value, (string) $option)) {
                $contains = true;
                break;
            }
        }

        if (!$contains) {
            $this->includeValidationError('Does not contain any of the options');
        }

        return $this;
    }

    public function isDate(): self
    {
        if (!strtotime($this->value)) {
            $this->includeValidationError('Value is not a date');
        }

        return $this;
    }

    private function includeValidationError(string $message): void
    {
        array_push($this->result, [
            'value' => $this->value,
            'message' => $message,
        ]);
    }

    // getters & setters

    public function getResult(): array
    {
        return $this->result;
    }
}
