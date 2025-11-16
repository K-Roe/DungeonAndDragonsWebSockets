<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Auth\Authenticatable;
use JsonSerializable;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User implements Authenticatable, JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $rememberToken = null;

    // 🔥 Custom API token for mobile auth (replaces Sanctum)
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $apiToken = null;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
    }

    // ---- Auth ----
    public function getAuthIdentifierName(): string { return 'id'; }
    public function getAuthIdentifier(): mixed { return $this->id; }
    public function getAuthPassword(): string { return $this->password; }
    public function getAuthPasswordName(): string { return 'password'; }
    public function getRememberToken(): ?string { return $this->rememberToken; }
    public function setRememberToken($value): void { $this->rememberToken = $value; }
    public function getRememberTokenName(): string { return 'remember_token'; }

    // ---- Getters / Setters ----
    public function getId(): int { return $this->id; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function setPassword(string $password): void { $this->password = $password; }

    // ---- API Token helpers (custom, not Sanctum) ----
    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $token): self
    {
        $this->apiToken = $token;
        return $this;
    }

    // ---- JSON ----
    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
        ];
    }
}
