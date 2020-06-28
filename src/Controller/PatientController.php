<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\User;
use App\Form\PatientType;
use App\Form\PatientTypeFollow;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Prescription;

/**
 * @Route("/patient")
 */
class PatientController extends AbstractController
{
    /**
     * @Route("/", name="patient_index", methods={"GET"})
     * @param PatientRepository $patientRepository
     * @return Response
     */
    public function index(PatientRepository $patientRepository): Response
    {
        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user_patient/{id}", name="user_patient_index", methods={"GET"})
     */
    public function indexUserPatient(UserInterface $user): Response
    {
        $patients = $user->getUserPatient();
        return $this->render('patient/user_patient/index.html.twig', [
            'patients' => $patients,
        ]);
    }

    /**
     * @Route("/new", name="patient_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request, UserInterface $user): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patient->addUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Voici votre nouveau code patient pour '.$patient->getName().' à garder precieusement, il vous sera demandé pour une nouvelle association : '
                .$patient->getId() . '.'
            );


            return $this->redirectToRoute('user_patient_index', ['id' =>  $user->getId() ]);
        }

        return $this->render('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patient_show", methods={"GET"})
     * @param Patient $patient
     * @return Response
     */
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="patient_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Patient $patient
     * @return Response
     */
    public function edit(Request $request, Patient $patient): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/follow", name="patient_follow", methods={"GET","POST"})
     */
    public function follow(Request $request, Patient $patient, UserInterface $user): Response
    {
        $form = $this->createForm(PatientTypeFollow::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patient->addUser($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_patient_index', ['id' =>  $user->getId() ]);
        }

        return $this->render('patient/user_patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patient_delete", methods={"DELETE"})
     * @param Request $request
     * @param Patient $patient
     * @return Response
     */
    public function delete(Request $request, Patient $patient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('patient_index');
    }
}
