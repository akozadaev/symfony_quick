<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Название не должно быть пустым.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Название не может быть длиннее {{ limit }} символов."
    )]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive(message: "Цена должна быть положительным числом.")]
    #[Assert\LessThanOrEqual(
        value: 1000000,
        message: "Цена не должна превышать {{ compared_value }}."
    )]
    private ?int $price = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Описание обязательно.")]
    #[Assert\Length(
        min: 10,
        minMessage: "Описание должно содержать минимум {{ limit }} символов."
    )]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAsArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'description' => $this->getDescription(),
        ];
    }
}
