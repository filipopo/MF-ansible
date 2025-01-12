<?php

namespace App\Entity;

use App\Repository\DonationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonationRepository::class)]
#[ORM\Index(columns: ['year', 'month'], name: 'year_month_idx')]
class Donation {
    public function __construct(
        string $time,
        int $day,
        int $month,
        int $year,
        string $name,
        string $message,
        float $amount_sent,
        float $amount_received,
        string $kofi_tx
    ) {
        $this->time = $time;
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->name = $name;
        $this->message = $message;
        $this->amount_sent = $amount_sent;
        $this->amount_received = $amount_received;
        $this->kofi_tx = $kofi_tx;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 8)]
    private ?string $time = null;

    #[ORM\Column]
    private ?int $day = null;

    #[ORM\Column]
    private ?int $month = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column]
    private ?float $amount_sent = null;

    #[ORM\Column]
    private ?float $amount_received = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $kofi_tx = null;
}
