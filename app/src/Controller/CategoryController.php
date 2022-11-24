<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategoryRepository;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_category', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): JsonResponse
    {
        $data = $categoryRepository->findAll();

        if(!$data) throw $this->createNotFoundException('No category registered');

        return $this->json([
            'data' => $data,
        ]);
    }

    #[Route('/categories/{id}', name: 'app_category_single', methods: ['GET'])]
    public function single(int $id, CategoryRepository $categoryRepository): JsonResponse
    {
        $id = $categoryRepository->find($id);

        if (!$id) throw $this->createNotFoundException('Category does not exist');

        return $this->json([
            'data' => $id,
        ]);
    }

    #[Route('/categories', name: 'app_category_create', methods: ['POST'])]
    public function create(Request $request, CategoryRepository $categoryRepository): JsonResponse
    {
        $data = $request->request->all();

        $category = new Category();
        $category->setName($data['name']);
        $category->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
        $category->setUpdatedAt(new \DateTimeImmutable('now',new \DateTimeZone('America/Sao_Paulo')));

        $categoryRepository->save($category, true);

        return $this->json([
            'message' => 'Category inserted',
            'data' => $category
        ],201);
    }

    #[Route('/categories/{id}', name: 'app_category_update', methods: ['PUT'])]
    public function update(int $id,Request $request, CategoryRepository $categoryRepository, ManagerRegistry $doctrine): JsonResponse
    {
        $data = $categoryRepository->find($id);

        if(!$data) throw $this->createNotFoundException('Category not found');

        $data = $request->request->all();
        $category->setName($data['name']);
        $category->setUpdatedAt(new \DateTimeImmutable('now',new \DateTimeZone('America/Sao_Paulo')));

       $doctrine->getManager()->flush();

        return $this->json([
            'message' => 'Category updated',
            'data' => $category
        ],201);
    }

    #[Route('/categories/{id}', name: 'app_category_delete', methods: ['DELETE'])]
    public function destroy(int $id, CategoryRepository $categoryRepository): JsonResponse
    {
        $id = $categoryRepository->find($id);

       $categoryRepository->remove($id,true);

        return $this->json([
            'message' => 'Category deleted',
            'data' => $id->setName(),
        ]);
    }
}
