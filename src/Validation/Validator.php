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

    public function checkLogin(string $login): void
    {
        $this->checkText($login, 'login', 62);
        if (!preg_match('/^[a-zA-Z0-9]+$/', $login))
        {
            $this->errors []= "Login must be only alphanumeric";
        }
    }

	public function checkText(string $text, string $name, int $maxlength, int $minlength = 1)
	{
		if (strlen($text) < $minlength) {
			$this->errors []= "$name length is less than the minimum";
		}
		if (strlen($text) > $maxlength) {
			$this->errors []= "$name length is more than the maximum";
		}
		if (!preg_match('/^[a-zа-я0-9ё.:;–,!?+()%\s\-]+$/iu', $text)) {
			$this->errors [] = "$name must be only alphanumeric";
		}
	}

	public function checkEngText(string $text, string $name, int $maxlength, int $minlength = 1)
	{
		if (!preg_match('/^[a-z0-9!?+()%\-]+$/iu', $text)) {
			$this->errors [] = "$name must be in English";
		}
	}

	public function checkInt(string $number, string $name, $min = null, $max = null)
	{
		if (!is_numeric($number) || !is_int($number + 0)) {
			$this->errors []= "$name must be only numeric";
		}
		if (!is_null($max) && $number > $max) {
			$this->errors [] = "$name is more than the maximum";
		}
		if (!is_null($min) && $number < $min) {
			$this->errors [] = "$name is less than the minimum";
		}
	}

	public function checkBool(string $boolValue, string $name)
	{
		$isBool = filter_var($boolValue, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
		if ($isBool === null) {
			$this->errors [] = "$name is not boolean";
		}
	}

	public function checkPath(string $path)
	{
		if (str_contains($path, '..')) {
			$this->errors [] = "The path is incorrect";
		}
	}

	public function checkPhone(string $phone)
	{
		if (!preg_match('/^\+7\d{10}$/', $phone)) {
			$this->errors [] = "The phone number does not match the Russian format";
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