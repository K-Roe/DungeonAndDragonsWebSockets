<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'jobs')]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $queue;

    #[ORM\Column(type: 'text')]
    private string $payload;

    #[ORM\Column(type: 'smallint')]
    private int $attempts;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $reservedAt = null;

    #[ORM\Column(type: 'integer')]
    private int $availableAt;

    #[ORM\Column(type: 'integer')]
    private int $createdAt;
}
