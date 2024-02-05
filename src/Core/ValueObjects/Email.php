<?php
namespace Core\ValueObjects;

use InvalidArgumentException;

class Email
{
    public function __construct(protected string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address');
        }
    }

    public static function from(string $email): Email
    {
        return new self($email);
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
