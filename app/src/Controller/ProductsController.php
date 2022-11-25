<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
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
    public function create(Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository): JsonResponse
    {
        $data = $request->request->all();

        $category = $categoryRepository->find((int)$data['category']);
        if (!$category) throw $this->createNotFoundException('Category does not exist');

        $product = new Product();
        $product->setCategory($category);
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

    #[Route('/products/update/{id}', name: 'products_update', methods: ['PUT', 'PATCH'])]
    public function update(int $id, Request $request, ProductRepository $productRepository, ManagerRegistry $doctrine, CategoryRepository $categoryRepository): JsonResponse
    {
        $product = $productRepository->find($id);
        $data = $request->request->all();

        if (!$product) throw $this->createNotFoundException('Product not found');

        if (isset($data['category'])) {
            $category = $categoryRepository->find((int)$data['category']);
            if (!$category) throw $this->createNotFoundException('Category does not exist');
            $product->setCategory($category);
        }

        if(isset($data['code'])) $product->setCode($data['code']);
        if(isset($data['name'])) $product->setName($data['name']);
        if(isset($data['price'])) $product->setPrice($data['price']);
        if(isset($data['pricePromotion'])) $product->setPricePromotion($data['pricePromotion']);
        if(isset($data['tax'])) $product->setTax($data['tax']);
        if(isset($data['promotion'])) $product->setPromotion($data['promotion']);
        if(isset($data['active'])) $product->setActive($data['active']);

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
