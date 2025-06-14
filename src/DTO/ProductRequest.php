<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ProductRequest
{
    public function __construct(
        #[Assert\NotBlank(message: "Название не должно быть пустым.")]
        #[Assert\Length(
            max: 255,
            maxMessage: "Название не может быть длиннее {{ limit }} символов."
        )]
        private readonly string $name,

        #[Assert\Positive(message: "Цена должна быть положительным числом.")]
        #[Assert\LessThanOrEqual(
            value: 1000000,
            message: "Цена не должна превышать {{ compared_value }}."
        )]
        private readonly float  $price,

        #[Assert\NotBlank(message: "Описание обязательно.")]
        #[Assert\Length(
            min: 10,
            minMessage: "Описание должно содержать минимум {{ limit }} символов."
        )]
        private readonly string $description
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}