<?php

namespace App\Mapper;

use App\DTO\ProductRequest;
use App\Entity\Product;

class ProductMapper {
    public function fromDto(ProductRequest $dto): Product {
        return (new Product())
            ->setName($dto->getName())
            ->setPrice($dto->getPrice())
            ->setDescription($dto->getDescription());
    }
    public function getById(ProductRequest $dto, int $id)
    {
        $product = $dto->getRepository(Product::class)->find($id);

    }
}
