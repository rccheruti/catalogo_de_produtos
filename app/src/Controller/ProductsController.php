<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProductRepository;
use App\Entity\Product;

class ProductsController extends AbstractController
{
    #[Route('/products', name: 'products_list', methods: ['GET'])]
    public function index(ProductRepository $productRepository): JsonResponse
    {
        $data = $productRepository->findAll();

        return $this->json([
            'data' => $data,
        ]);
    }

    #[Route('/products/{id}', name: 'products_single', methods: ['GET'])]
    public function single(int $id, ProductRepository $productRepository): JsonResponse
    {
        $id = $productRepository->find($id);

        if (!$id) throw $this->createNotFoundException('Product does not exist');

        return $this->json([
            'data' => $id,
        ]);
    }

    #[Route('/products/create', name: 'products_create', methods: ['POST'])]
    public function create(Request $request, ProductRepository $productRepository): JsonResponse
    {
        $data = $request->request->all();
//        return $this->json([$data['category_id']]);

        $product = new Product();
        $product->setCategory($data['category']);
        $product->setCode($data['code']);
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setPricePromotion($data['pricePromotion']);
        $product->setTax($data['tax']);
        $product->setPromotion($data['promotion']);
        $product->setActive($data['active']);
        $product->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
        $product->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $productRepository->save($product, true);

        return $this->json([
            'message' => 'Product inserted successfully',
            'data' => $product
        ], 201);
    }

    #[Route('/products/update/{id}', name: 'products_update', methods: ['PUT'])]
    public function update(int $id, Request $request, ProductRepository $productRepository, ManagerRegistry $doctrine): JsonResponse
    {
        $product = $productRepository->find($id);

        if (!$product) throw $this->createNotFoundException('Product not found');

        $data = $request->request->all();
        $product->setCategory($data['category']);
        $product->setCode($data['code']);
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setPricePromotion($data['pricePromotion']);
        $product->setTax($data['tax']);
        $product->setPromotion($data['promotion']);
        $product->setActive($data['active']);
        $product->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $doctrine->getManager()->flush();

        return $this->json([
            'message' => 'Product updated',
            'data' => $product
        ]);
    }

    #[Route('/products/delete/{id}', name: 'products_delete', methods: ['DELETE'])]
    public function destroy(int $id, Request $request, ProductRepository $productRepository): JsonResponse
    {
        $id = $productRepository->find($id);

        $productRepository->remove($id, true);

        return $this->json([
            'data' => $id->getName(),
        ]);
    }
}
