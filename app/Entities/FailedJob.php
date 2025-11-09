<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'failed_jobs')]
class FailedJob
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $uuid;

    #[ORM\Column(type: 'text')]
    private string $connection;

    #[ORM\Column(type: 'text')]
    private string $queue;

    #[ORM\Column(type: 'text')]
    private string $payload;

    #[ORM\Column(type: 'text')]
    private string $exception;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $failedAt;
}
