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

class UserController extends AbstractController
{
    /**
     * @Route("/api/store_user", name="store_user",methods={"POST"})
     */
    public function storeUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator):Response
    {
        
        try {
            $user = new User();
            $getjson = $request->getContent();

            $user = $serializer->deserialize($getjson, User::class, 'json');


            $user->setRoles(array('ROLE_USER'));
            $user->setCustomer();
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
}
