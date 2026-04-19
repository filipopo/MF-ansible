<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DonationRepository;

class MainController extends AbstractController {
    #[Route('/', name: 'app_index')]
    public function index(DonationRepository $donationRepo): Response {
        $costHistory = $this->getParameter('app.cost_history');

        return $this->render('index.html.twig', [
            'kofi_name' => $this->getParameter('app.kofi_name'),
            'slides' => glob('images/slide-*'),
            'kofi_currency' => $this->getParameter('app.kofi_currency'),
            'balance' => $donationRepo->getMonthlyBalance(date('Y'), date('n')),
            'kofi_target' => end($costHistory)['cost'],
            'donations' => $donationRepo->getLatestDonations(),
            'kofi_startdate' => $costHistory[0]['date']
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
        $totalServerCost = 0.0;

        $costHistory = $this->getParameter('app.cost_history');
        $now = microtime(true);

        for ($i = 0; $i < count($costHistory); $i++) {
            $periodStart = strtotime($costHistory[$i]['date']);

            // If the start date is in the future, ignore it for now
            if ($periodStart > $now) {
                break;
            }

            // The period ends when the NEXT price starts, or "now" if it's the current price
            $periodEnd = strtotime($costHistory[$i + 1]['date'] ?? null) ?: $now;
            $periodEnd = min($periodEnd, $now);

            // Add this period's cost to the total, 3600 * 24 * 365.25 / 12
            $totalServerCost += ($periodEnd - $periodStart) / 2629800 * $costHistory[$i]['cost'];
        }

        return $this->render('stats.html.twig', [
            'kofi_currency' => $this->getParameter('app.kofi_currency'),
            'sum' => $sum,
            'num' => $donationRepo->count(),
            'avg' => $donationRepo->getAverageDonation(),
            'balance' => number_format($sum - $totalServerCost, 2),
            'donators' => $donationRepo->getTopDonators(),
            'donations' => $donationRepo->getDonationActivity()
        ]);
    }
}
