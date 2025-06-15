<?php

namespace App\Service;

use App\DTO\ProductRequest;
use App\Entity\Product;
use App\Mapper\ProductMapper;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ProductMapper          $mapper,
        private readonly ProductRepository      $repository
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
        return $this->repository->findOneBy(['id' => $id]);
    }

    public function fetch(): array
    {
        return $this->repository->findAll();
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function edit(int $id, mixed $parameters): ?Product
    {
        return $this->repository->update($id, $parameters);
    }
}
