<?php

namespace App\Repository;

use App\DTO\ProductRequest;
use App\Entity\Product;
use App\Mapper\ProductMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use http\Exception\RuntimeException;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    private ProductMapper $mapper;
    private EntityManagerInterface $em;

    public function __construct(
        ManagerRegistry        $registry,
        ProductMapper          $mapper,
        EntityManagerInterface $em)
    {
        parent::__construct($registry, Product::class);
        $this->mapper = $mapper;
        $this->em = $em;
    }

    public function create(ProductRequest $dto): ?Product
    {
        $product = $this->mapper->fromDto($dto);
        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }

    public function update(int $id, mixed $parameters): ?Product
    {
        $product = $this->findOneBy(['id' => $id]);

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

    public function delete(int $id): void
    {
        $this->createQueryBuilder('p')
            ->delete('App\Entity\Product', 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }
}
