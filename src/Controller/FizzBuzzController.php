<?php
namespace App\Controller;

use App\Service\FizzBuzzService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FizzBuzzController extends AbstractController
{
    #[Route('/fizzbuzz', name: 'app_fizzbuzz_input', methods: ['GET'])]
    public function showInputForm(): Response
    {
        return $this->render('fizzbuzz/input.html.twig');
    }

    #[Route('/fizzbuzz/result', name: 'app_fizzbuzz_result', methods: ['POST'])]
    public function processForm(
        Request $request,
        FizzBuzzService $fizzBuzzService,
        SessionInterface $session
    ): RedirectResponse {
        $number = (int) $request->request->get('number');
        $result = $fizzBuzzService->getSequence($number);

        // Zapisz wynik w sesji
        $session->set('fizzbuzz_result', $result);
        $session->set('fizzbuzz_number', $number);

        return $this->redirectToRoute('app_fizzbuzz_show_result');
    }

    #[Route('/fizzbuzz/result/show', name: 'app_fizzbuzz_show_result', methods: ['GET'])]
    public function showResult(SessionInterface $session): Response
    {
        // Pobierz wynik z sesji
        $result = $session->get('fizzbuzz_result', []);
        $number = $session->get('fizzbuzz_number', null);

        // Wyczyść sesję po wyświetleniu wyniku
        $session->remove('fizzbuzz_result');
        $session->remove('fizzbuzz_number');

        return $this->render('fizzbuzz/result.html.twig', [
            'result' => $result,
            'number' => $number
        ]);
    }
}