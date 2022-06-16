<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Customer;
use Hateoas\HateoasBuilder;
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



class UserController extends AbstractController
{
    /**
     * @OA\Post(
     *     path="/api/store_user",
     *   summary="Créer un nouvel utilisateur",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         @OA\Property(
     *           property="firstname",
     *           description="Prénom de l'utilisateur",
     *           type="string",
     *           default="Saul"
     *         ),
     *         @OA\Property(
     *           property="lastname",
     *           description="Nom de l'utilisateur",
     *           type="string",
     *           default="Goodman"
     *         ),
     *         @OA\Property(
     *           property="email",
     *           description="e-mail de l'utilisateur",
     *           type="string",
     *           default="saul.goodman@email.com"
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
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )
     *   ),
     *   @OA\Response(response=400, description="Erreur de syntaxe"),
     *   @OA\Response(
     *     response=401,
     *     description="JWT erreur de token"
     *   ),
     * )
     * @Route("/api/store_user", name="store_user",methods={"POST"})
     */
    public function storeUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordEncoder, ValidatorInterface $validator):Response
    {
        
        try {
            $getjson = $request->getContent();

            $user = $serializer->deserialize($getjson, User::class, 'json');


            $user->setRoles(array('ROLE_USER'));
            $user->setCustomer($this->getUser());
            if ($user->getPlainPassword()) {
                $user->setPassword(
                    $userPasswordEncoder->hashPassword($user, $user->getPlainPassword())
                );
            }
            $em->persist($user);
            $em->flush();
            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }


            return $this->json($user, 201, [], ['groups' => 'user:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()

            ], 400);
        }

       
    }

     /**
      * @OA\Delete(
     *     path="/api/delete_user/{id}",
     *   summary="Supprimer un utilisateur par ID",
     *   @OA\Response(response=204, description="ok"),
     *   @OA\Response(response=401, description="Erreur du token jwt"),
     *   @OA\Response(response=404, description="Aucun utilisateur avec cet id"),
     *   @OA\PathParameter(
     *     name="id",
     *     description="ID de l'utilisateur qui va être supprimé"
     *   )
     * )
     * @Route("/api/delete_user/{id}", name="delete_user",methods={"DELETE"})
     */
    public function deleteUser(EntityManagerInterface $em,User $user)
    {
        $em->remove($user);
        $em->flush();

        return new Response('ok');


       
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *   summary="Liste des utilisateurs",
     *   @OA\Response(response=200, description="tous les utilisateurs"),
     *   @OA\Response(response=401, description="Erreur du token jwt"),
     *   @OA\Response(response=404, description="Aucun utilisateur trouvé")
     * )
     * @Route("/api/users", name="Users",methods={"GET"} )
     */
    public function listUser(UserRepository $userRepository): Response
    {
        $hateoas = HateoasBuilder::create()->build();

      $user = $userRepository->findAll();

      $json = $hateoas->serialize($user, 'json', SerializationContext::create()->setGroups(array('customer:read')));
      return new JsonResponse($json, 200, [], true);
    }

    /**
     * @OA\Get(
     *     path="/api/user/{id}",
     *   summary="Recuperer un utilisateur par ID",
     *   @OA\PathParameter(
     *     name="id",
     *     description="l'id de l'utilisateur que vous voulez recuperer"
     *   ),
     *   @OA\Response(response=200, description="Détail de l'utilisateur"),
     *   @OA\Response(response=401, description="Erreur du token JWT"),
     *   @OA\Response(response=404, description="Aucun utilisateur trouvé avec cet ID")
     * )
     * @Route("api/user/{id}", name="User",methods={"GET"})
     */
    public function findUser(UserRepository $userRepository,$id,SerializerInterface $serializer)
    {
        $hateoas = HateoasBuilder::create()->build();

        $user = $userRepository->find($id);
 
        $json = $hateoas->serialize($user, 'json', SerializationContext::create()->setGroups(array('customer:read')));
        return new JsonResponse($json, 200, [], true);

    }
}
