<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Customer;
use App\Repository\UserRepository;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class UserController extends AbstractController
{
    /**
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
     * @Route("/api/delete_user/{id}", name="delete_user",methods={"DELETE"})
     */
    public function deleteUser(EntityManagerInterface $em,User $user)
    {
        $em->remove($user);
        $em->flush();

        return new Response('ok');


       
    }

    /**
     * @Route("/api/listuser", name="RouteName")
     */
    public function listUser(UserRepository $userRepository,SerializerInterface $serializer): Response
    {
      $user = $userRepository->findAll();

      $usersnormalize = $serializer->serialize($user,'json',['groups'=>'user:read']);

      $json = json_encode($usersnormalize);

      $response = new JsonResponse($json,200,[],true);


      return $response;
    }
}
