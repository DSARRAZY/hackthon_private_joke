<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\WebpackEncoreBundle;
use Symfony\Component\Security\Core\User\UserInterface;

class HomeController extends AbstractController
{
    /**
     * Home page display
     * @Route("/",name="home_index")
     * @param Request $request
     * @param UserInterface $user
     * @return Response A response instance
     */
    public function index(Request $request, ?Userinterface $user) :Response
    {

        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('code')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $id = $data['code'];
            return $this->redirectToRoute('patient_follow', ['id' =>  $id ]);
        }

        return $this->render('index.html.twig', ['form' => $form->createView(),
                                                'user' => $user]);
    }
}