<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cache')]
class Cache
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    private string $key;

    #[ORM\Column(type: 'text')]
    private string $value;

    #[ORM\Column(type: 'integer')]
    private int $expiration;

    public function getKey(): string { return $this->key; }
    public function setKey(string $key): void { $this->key = $key; }

    public function getValue(): string { return $this->value; }
    public function setValue(string $value): void { $this->value = $value; }

    public function getExpiration(): int { return $this->expiration; }
    public function setExpiration(int $expiration): void { $this->expiration = $expiration; }
}
