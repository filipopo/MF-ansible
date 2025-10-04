<?php

namespace App\Repository;

use App\Entity\Donation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Donation>
 */
class DonationRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Donation::class);
    }

    public function getMonthlyBalance(string $year, string $month): float {
        $query = $this->getEntityManager()->createQuery(
            'SELECT SUM(d.amount_received)
            FROM App\Entity\Donation d
            WHERE d.year=:year
            AND d.month=:month'
        )->setParameters([
            'year' => $year,
            'month' => $month,
        ]);

        return (float)$query->getSingleScalarResult();
    }

    public function getLatestDonations(): array {
        $query = $this->getEntityManager()->createQuery(
            'SELECT d.time, d.day, d.month, d.year, d.name, d.message, d.amount_sent
            FROM App\Entity\Donation d
            ORDER BY d.id DESC'
        )->setMaxResults(10);

        return $query->getResult();
    }

    public function getTotalDonations(): float {
        $query = $this->getEntityManager()->createQuery(
            'SELECT SUM(d.amount_received)
            FROM App\Entity\Donation d'
        );

        return (float)$query->getSingleScalarResult();
    }

    public function getTopDonators(): array {
        $query = $this->getEntityManager()->createQuery(
            'SELECT SUM(d.amount_sent) AS amount, COUNT(d) AS times, d.name
            FROM App\Entity\Donation d
            GROUP BY d.name
            ORDER BY amount DESC, times DESC, d.id DESC'
        )->setMaxResults(10);

        return $query->getResult();
    }

    public function getDonationActivity(): array {
        $query = $this->getEntityManager()->createQuery(
            'SELECT SUM(d.amount_received) AS amount, d.month, d.year
            FROM App\Entity\Donation d
            GROUP BY d.year, d.month
            ORDER BY d.year DESC, d.month DESC'
        )->setMaxResults(12);

        return array_reverse($query->getResult());
    }
}
