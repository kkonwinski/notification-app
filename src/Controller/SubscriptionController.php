<?php

namespace App\Controller;

use App\Entity\Person;
use App\Notifier\NotificationSubject;
use App\Notifier\PersonObserver;
use App\Repository\PersonRepository;
use App\Services\SubscriptionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/subscription')]
class SubscriptionController extends AbstractController
{
    #[Route('/{personId}', name: 'app_subscription_index', methods: ['GET'])]
    public function index(int $personId, PersonRepository $personRepository, SubscriptionService $subscriptionService): Response
    {
        $person = $personRepository->find($personId);
        if (!$person) {
            throw $this->createNotFoundException();
        }

        $sub = $subscriptionService->getSubscriptionStatus($person->getId());

        return $this->render('subscription/index.html.twig', [
            'person' => $person,
            'emailSubscribed' => $sub['email'],
            'smsSubscribed' => $sub['sms'],
        ]);
    }

    #[Route('/subscribe/{personId}/{type}', name: 'app_subscription_subscribe', methods: ['GET'])]
    public function subscribe(int $personId, string $type, SubscriptionService $subscriptionService, PersonRepository $personRepository): Response
    {
        $person = $personRepository->find($personId);
        if (!$person) {
            throw $this->createNotFoundException();
        }

        $subscriptionService->setSubscription($person->getId(), $type, true);
        return $this->redirectToRoute('app_person_index');
    }

    #[Route('/unsubscribe/{personId}/{type}', name: 'app_subscription_unsubscribe', methods: ['GET'])]
    public function unsubscribe(int $personId, string $type, SubscriptionService $subscriptionService, PersonRepository $personRepository): Response
    {
        $person = $personRepository->find($personId);
        if (!$person) {
            throw $this->createNotFoundException();
        }

        $subscriptionService->setSubscription($person->getId(), $type, false);
        return $this->redirectToRoute('app_person_index');
    }

    #[Route('/notify-all', name: 'app_subscription_send_notification', methods: ['POST'])]
    public function sendNotification(Request $request, PersonRepository $personRepository, SubscriptionService $subscriptionService): Response
    {
        $message = $request->request->get('message');
        $subject = new NotificationSubject();
        $people = $personRepository->findAll();

        foreach ($people as $person) {
            $sub = $subscriptionService->getSubscriptionStatus($person->getId());
            if ($sub['email'] || $sub['sms']) {
                $subject->attach(new PersonObserver($person, $subscriptionService));
            }
        }

        $subject->notifyAll($message);

        return $this->redirectToRoute('app_person_index');
    }
}
