<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'job_batches')]
class JobBatch
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $totalJobs;

    #[ORM\Column(type: 'integer')]
    private int $pendingJobs;

    #[ORM\Column(type: 'integer')]
    private int $failedJobs;

    #[ORM\Column(type: 'text')]
    private string $failedJobIds;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $options = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $cancelledAt = null;

    #[ORM\Column(type: 'integer')]
    private int $createdAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $finishedAt = null;
}
