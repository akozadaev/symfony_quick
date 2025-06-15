<?php

namespace App\Service;

use App\DTO\ProductRequest;
use App\Entity\Product;
use App\Mapper\ProductMapper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ProductMapper          $mapper
    )
    {
    }

    public function create(ProductRequest $dto): Product
    {
        $product = $this->mapper->fromDto($dto);

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }

    public function get(int $id): Product
    {
        return $this->em->getRepository(Product::class)->find($id);
    }
    public function fetch(): array
    {
        return $this->em->getRepository(Product::class)->findAll();
    }

    public function delete(int $id): bool
    {
        $product = $this->em->getRepository(Product::class)->find($id);
        if (empty($product)) {
            return false;
        } else {
            $this->em->remove($product);
            $this->em->flush();
            return true;
        }
    }

    public function edit(int $id, mixed $parameters): ?Product
    {
        $product = $this->em->getRepository(Product::class)->find($id);
        if (empty($product)) {
            return $product;
        } else {
            $product->setName($parameters['name']);
            $product->setPrice($parameters['price']);
            $product->setDescription($parameters['description']);

            $this->em->persist($product);
            $this->em->flush();
        }
        return $product;
    }
}
