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
use OpenApi\Annotations as OA;


class ProductController extends AbstractController
{
    /**
     * @OA\Get(
     *   tags={"Product"},
     *   summary="Liste des produits",
     *   @OA\Response(response=200, description="Tous les produits"),
     *   @OA\Response(response=401, description="Erreur du token jwt"),
     *   @OA\Response(response=404, description="Aucun produit trouvé")
     * )
     * @Route("/api/products", name="api_product_index",methods={"GET"})
     */
    public function index(ProductRepository $productRepository,SerializerInterface $serializer)
    {
      $products = $productRepository->findAll();

      $productsnormalize = $serializer->serialize($products,'json',['groups'=>'show_product']);


      $response = new JsonResponse($productsnormalize,200,[],true);


      return $response;


    }

  

    /**
     *  
     * @OA\Get(
     *     path="/product/{id}",
     *   summary="Recuperer un produit par ID",
     *   @OA\PathParameter(
     *     name="id",
     *     description="l'id du produit que vous voulez recuperer"
     *   ),
     *   @OA\Response(response=200, description="Detail du produit"),
     *   @OA\Response(response=404, description="Aucun produit trouvé avec cet ID")
     * )
     *
     * @Route("/product/{id}", name="api_find_product", methods={"GET"})
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
