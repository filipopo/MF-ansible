<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DonationRepository;

class MainController extends AbstractController {
    #[Route('/', name: 'app_index')]
    public function index(DonationRepository $donationRepo): Response {
        $balance = $donationRepo->getMonthlyBalance(date('Y'), date('n'));

        return $this->render('index.html.twig', [
            'kofi_name' => $this->getParameter('app.kofi_name'),
            'slides' => glob('images/slide-*'),
            'kofi_currency' => $this->getParameter('app.kofi_currency'),
            'balance' => $balance,
            'kofi_target' => $this->getParameter('app.kofi_target'),
            'donations' => $donationRepo->getLatestDonations(),
            'kofi_startdate' => $this->getParameter('app.kofi_startdate')
        ]);
    }

    #[Route('/servers', name: 'app_servers')]
    public function servers(DonationRepository $donationRepo): Response {
        return $this->render('servers.html.twig');
    }

    #[Route('/guides', name: 'app_guides')]
    public function guides(DonationRepository $donationRepo): Response {
        return $this->render('guides.html.twig', [
            'files' => array_map(
                fn($f) => pathinfo($f, PATHINFO_FILENAME),
                glob('html/*')
            )
        ]);
    }

    #[Route('/stats', name: 'app_stats')]
    public function stats(DonationRepository $donationRepo): Response {
        $sum = $donationRepo->getTotalDonations();

        // 3600 / 24 / 30
        $balance = $sum - (microtime(true) - strtotime($this->getParameter('app.kofi_startdate')))
        / 2592000 * $this->getParameter('app.kofi_target');

        return $this->render('stats.html.twig', [
            'kofi_currency' => $this->getParameter('app.kofi_currency'),
            'sum' => $sum,
            'num' => $donationRepo->count(),
            'balance' => $balance,
            'donators' => $donationRepo->getTopDonators(),
            'donations' => $donationRepo->getDonationActivity()
        ]);
    }
}
