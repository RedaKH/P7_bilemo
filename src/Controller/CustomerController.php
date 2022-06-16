<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Customer;
use Hateoas\HateoasBuilder;
use PhpParser\Node\Stmt\TryCatch;
use App\Repository\UserRepository;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use OpenApi\Annotations as OA;



class CustomerController extends AbstractController
{




    /**
     *  @OA\Delete(
     *   path="/delete_customer/{id}",
     *   summary="Supprimer un client par ID",
     *   @OA\Response(response=204, description="ok"),
     *   @OA\Response(response=401, description="Erreur du token jwt "),
     *   @OA\Response(response=404, description="Aucun client avec cet id"),
     *   @OA\PathParameter(
     *     name="id",
     *     description="ID du client qui va être supprimé"
     *   )
     * )
     * @Route("/delete_customer/{id}", name="delete_customer",methods={"DELETE"})
     */
    public function deleteCustomer(EntityManagerInterface $em, Customer $customer)
    {
        $em->remove($customer);
        $em->flush();

        return new Response('ok');
    }


    /**
     * 
     *   
     * @OA\Get(
     *     path="/api/customer/{id}",
     *   summary="Recuperer un client par ID",
     *   @OA\PathParameter(
     *     name="id",
     *     description="l'id du client que vous voulez recuperer"
     *   ),
     *   @OA\Response(response=200, description="Detail du client"),
     *   @OA\Response(response=401, description="Erreur du token JWT"),
     *   @OA\Response(response=404, description="Aucun client trouvé avec cet ID")
     * )
     * 
     * 
     * @Route("/api/customer/{id}", name="Customer",methods={"GET"})
     * 
     * 
     * 
     */
    public function findCustomer(CustomerRepository $customerRepository, $id)
    {
        $hateoas = HateoasBuilder::create()->build();

        $customer = $customerRepository->find($id);

        $json = $hateoas->serialize($customer, 'json', SerializationContext::create()->setGroups(array('customer:read')));
        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @OA\Get(
     *    path="/api/customers",
     *   summary="Liste des clients",
     *   @OA\Response(response=200, description="tous les clients"),
     *   @OA\Response(response=401, description="Erreur du token jwt"),
     *   @OA\Response(response=404, description="Aucun client trouvé")
     * )
     * 
     * 
     * @Route("/api/customers", name="Customers",methods={"GET"} )
     */
    public function listCustomers(CustomerRepository $customerRepository): Response
    {
        $hateoas = HateoasBuilder::create()->build();

        $customer = $customerRepository->findAll();

        $json = $hateoas->serialize($customer, 'json', SerializationContext::create()->setGroups(array('customer:read')));
        return new JsonResponse($json, 200, [], true);
    }


/**
     * @OA\Post(
     *     path="/store_customer",
     *   summary="Créer un nouveau client",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         @OA\Property(
     *           property="firstname",
     *           description="Prénom du client",
     *           type="string",
     *           default="John"
     *         ),
     *         @OA\Property(
     *           property="lastname",
     *           description="Nom du client",
     *           type="string",
     *           default="Doe"
     *         ),
     *         @OA\Property(
     *           property="email",
     *           description="e-mail de l'utilisateur",
     *           type="string",
     *           default="john.doe@email.com"
     *         ),
     *          @OA\Property(
     *           property="password",
     *           description="Mot de passe de l'utilisateur",
     *           type="string"
     *         ),
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Utilisateur créer",
     *     @OA\JsonContent(
     *       type="array",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Customer"))
     *     )
     *   ),
     *   @OA\Response(response=400, description="Erreur de syntaxe"),
     *   @OA\Response(
     *     response=401,
     *     description="JWT erreur de token"
     *   ),
     * )
     * @Route("/store_customer", name="store_customer",methods={"POST"})
     */
    public function storeCustomer(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordHasherInterface $customerPasswordEncoder, ValidatorInterface $validator):Response
    {
        
        try {
            $getjson = $request->getContent();

            $customer= $serializer->deserialize($getjson, Customer::class, 'json');


            $customer->setRoles(array('ROLE_USER'));
            if ($customer->getPlainPassword()) {
                $customer->setPassword(
                    $customerPasswordEncoder->hashPassword($customer, $customer->getPlainPassword())
                );
            }
            $em->persist($customer);
            $em->flush();
            $errors = $validator->validate($customer);
            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }


            return $this->json($customer, 201, [], ['groups' => 'customer:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()

            ], 400);
        }

       
    }}
