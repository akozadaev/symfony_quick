<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'create_product', methods: ['POST'])]
    public function createProduct(EntityManagerInterface $entityManager, ValidatorInterface $validator, Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setName($parameters['name']);
        $product->setPrice($parameters['price']);
        $product->setDescription($parameters['description']);

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new JsonResponse((string)$errors, 400);
        }

        $entityManager->persist($product);
        $entityManager->flush();

        return new JsonResponse($product->getAsArray());
    }

    #[Route('/product/{id}', name: 'product_show', methods: ['GET'])]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        return new JsonResponse($product->getAsArray());
    }

    #[Route('/product/edit/{id}', name: 'product_edit', methods: ['PATCH'])]
    public function update(EntityManagerInterface $entityManager, int $id, ValidatorInterface $validator, Request $request): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
        $parameters = json_decode($request->getContent(), true);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $product->setName($parameters['name']);
        $product->setPrice($parameters['price']);
        $product->setDescription($parameters['description']);

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new JsonResponse((string)$errors, 400);
        }

        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $product->getId()
        ]);
    }

    #[Route('/product/delete/{id}', name: 'product_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return new JsonResponse(["success" => true]);
    }
}