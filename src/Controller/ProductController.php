<?php

namespace App\Controller;

use App\DTO\ProductRequest;
use App\Entity\Product;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/products', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] ProductRequest $dto,
        ProductService                      $service
    ): JsonResponse
    {
        $product = $service->create($dto);
        return new JsonResponse($product->getAsArray());
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(ProductService $service, int $id): Response
    {
        $product = $service->get($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        return new JsonResponse($product->getAsArray());
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['PATCH'])]
    public function update(ProductService $service, int $id, Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $product = $service->edit($id, $parameters);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        return new JsonResponse($product->getAsArray());
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(ProductService $service, int $id): Response
    {
        $service->delete($id);
            return new Response();
    }

    #[Route('', name: 'all', methods: ['GET'])]
    public function all(ProductService $service): Response
    {

        $result = $service->fetch();
        $datum = [];
        /** @var Product $item*/
        foreach ($result as $item) {
            $datum[] = $item->getAsArray();
        }
        $data = [];
        $data['meta'] = ['count' =>count($result)];
        $data['data'] = $datum;
        return new JsonResponse($data);
    }

}