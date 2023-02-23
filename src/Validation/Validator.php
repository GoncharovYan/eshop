<?php

namespace Validation;

class Validator
{

    public array $errors = [];

    public function checkEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->errors []= "Email not correct";
        }
    }

    public function checkMin(string $str, string $strName, int $min = 1): void
    {
       if(strlen($str) < $min)
       {
           $this->errors []= "Minimum string length for {$strName}: {$min}";
       }
    }

    public function checkLogin(string $login): void
    {
        $this->checkMin($login, 'login');
        if (!preg_match('/^[a-zA-Z0-9-_]+$/', $login))
        {
            $this->errors []= "Login must be only alphanumeric";
        }
    }

    public function isSuccess(): bool
    {
        if(empty($this->errors))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getErrors(): array
    {
        if(!$this->isSuccess())
        {
            return $this->errors;
        }
        else
        {
            return [];
        }
    }

}