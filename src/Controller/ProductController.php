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
     * @OA\Post(
     *     path="/api/store_product",
     *   summary="Créer un nouveau produit",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         @OA\Property(
     *           property="name",
     *           description="Nom du produit",
     *           type="string",
     *           default="Samsung Galaxy S10"
     *         ),
     *         @OA\Property(
     *           property="description",
     *           description="description du produit",
     *           type="string",
     *           default=" Ecran : large 5,8"
     *         ),
     *         @OA\Property(
     *           property="price",
     *           description="Prix du produit",
     *           type="float",
     *           default="499.99"
     *         ),
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Created product",
     *     @OA\JsonContent(
     *       type="array",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
     *     )
     *   ),
     *   @OA\Response(response=400, description="Le champ du json est invalide ou erreur de syntaxe"),
     *   @OA\Response(
     *     response=401,
     *     description="Erreur de token json"
     *   ),
     * )
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
