<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Customer;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class CustomerController extends AbstractController
{
 

    /**
     * @Route("/store_customer", name="store_customer",methods={"POST"})
     */
    public function storeCustomer(Request $request,SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator)
    {

        try {
            $getjson = $request->getContent();

            $customer = $serializer->deserialize($getjson, Customer::class, 'json');

            $customer->setRoles(array('ROLE_USER'));

            $em->persist($customer);
            $em->flush();
            $errors = $validator->validate($customer);
            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }


            return $this->json($customer, 201, [], ['groups' => 'user:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()

            ], 400);
        }
    }

    /**
     * @Route("/delete_customer/{id}", name="delete_customer",methods={"DELETE"})
     */
    public function deleteCustomer(EntityManagerInterface $em,Customer $customer)
    {
        $em->remove($customer);
        $em->flush();

        return new Response('ok');


       
    }
    

    /**
     * @Route("/findCustomer/{id}", name="findCustomer")
     */
    public function findUsers()
    {


    }


}
