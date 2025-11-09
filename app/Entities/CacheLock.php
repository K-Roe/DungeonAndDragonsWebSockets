<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cache_locks')]
class CacheLock
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    private string $key;

    #[ORM\Column(type: 'string', length: 255)]
    private string $owner;

    #[ORM\Column(type: 'integer')]
    private int $expiration;
}
