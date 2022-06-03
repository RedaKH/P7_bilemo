<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/product", name="api_product_index",methods={"GET"})
     */
    public function index(ProductRepository $productRepository,SerializerInterface $serializer)
    {
      $products = $productRepository->findAll();

      $productsnormalize = $serializer->serialize($products,'json',['groups'=>'show_product']);

      $json = json_encode($productsnormalize);

      $response = new JsonResponse($json,200,[],true);


      return $response;


    }

    /**
     * @Route("/api/store_product", name="store",methods={"POST"})
     */
    public function store(Request $request, SerializerInterface $serializer,CustomerRepository $repo, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        try {
            
            $getjson = $request->getContent();

            $product = $serializer->deserialize($getjson, Product::class, 'json');

            $product->setCreatedAt(new \DateTime());

            $em->persist($product);
            $em->flush();
            $errors = $validator->validate($product);
            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }


            return $this->json($product, 201, [], ['groups' => 'show_product']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()

            ], 400);
        }
    }

    /**
     * @Route("api/product/{id}", name="api_find_product", methods={"GET"})
     */
    public function api_find_product(ProductRepository $productRepository,$id, SerializerInterface $serializer)
    {
       $product = $productRepository->find($id);
       $productsnormalize = $serializer->serialize($product,'json',['groups'=>'products:read']);

        $json = json_encode($productsnormalize);
  
        $response = new JsonResponse($json,200,[],true);
  
  
        return $response;
  


        
    }

}
