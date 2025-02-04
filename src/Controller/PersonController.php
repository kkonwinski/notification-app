<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use App\Services\SubscriptionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/person')]
class PersonController extends AbstractController
{
    #[Route('/', name: 'app_person_index', methods: ['GET'])]
    public function index(PersonRepository $personRepository, SubscriptionService $subscriptionService): Response
    {
        $people = $personRepository->findAll();
        $personsWithSubscription = [];

        foreach ($people as $p) {
            $sub = $subscriptionService->getSubscriptionStatus($p->getId());
            $personsWithSubscription[] = [
                'person' => $p,
                'emailSubscribed' => $sub['email'],
                'smsSubscribed' => $sub['sms']
            ];
        }

        return $this->render('person/index.html.twig', [
            'persons' => $personsWithSubscription
        ]);
    }

    #[Route('/new', name: 'app_person_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PersonRepository $personRepository): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personRepository->add($person, true);
            return $this->redirectToRoute('app_person_index');
        }

        return $this->render('person/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_person_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, PersonRepository $personRepository): Response
    {
        $person = $personRepository->find($id);
        if (!$person) {
            throw $this->createNotFoundException('Person not found');
        }

        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personRepository->add($person, true);
            return $this->redirectToRoute('app_person_index');
        }

        return $this->render('person/edit.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/delete/{id}', name: 'app_person_delete', methods: ['GET'])]
    public function delete(int $id, PersonRepository $personRepository): Response
    {
        $person = $personRepository->find($id);
        if ($person) {
            $personRepository->remove($person, true);
        }
        return $this->redirectToRoute('app_person_index');
    }
}
