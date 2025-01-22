<?php

namespace App\Controller;

use App\Entity\Donation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DonationController extends AbstractController {
    #[Route('/donate_notify', name: 'app_donate', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response {
        if ($file = fopen('../donation_log.txt', 'a')) {
            fwrite($file, sprintf("%s %s\n", date(DATE_RFC2822), $request->getContent()));
            fclose($file);
        }

        $data = json_decode($request->request->get('data'), true);
        if (!$data) {
            return new Response('Invalid request', Response::HTTP_BAD_REQUEST);
        }

        if (!hash_equals($this->getParameter('app.kofi_token'), $data['verification_token'])) {
            return new Response('Verification token mismatch', Response::HTTP_BAD_REQUEST);
        }

        $donation = new Donation(
            date: date_parse($data['timestamp']),
            name: ucfirst($data['from_name']),
            message: $data['message'],
            amount_sent: $data['amount'],
            amount_received: $data['amount'],
            kofi_tx: $data['kofi_transaction_id']
        );

        $entityManager->persist($donation);
        $entityManager->flush();

        return new Response();
    }
}
