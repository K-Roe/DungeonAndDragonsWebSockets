<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $emailVerifiedAt = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $rememberToken = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'tokenable', targetEntity: PersonalAccessToken::class, cascade: ['persist', 'remove'])]
    private Collection $tokens;


    // --- Laravel Auth methods ---

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string|null $rememberToken
     */
    public function __construct(string $name, string $email, string $password, ?string $rememberToken = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->rememberToken = $rememberToken;
    }

    public function getAuthIdentifierName(): string { return 'id'; }
    public function getAuthIdentifier(): mixed { return $this->id; }
    public function getAuthPassword(): string { return $this->password; }
    public function getAuthPasswordName(): string { return 'password'; }
    public function getRememberToken(): ?string { return $this->rememberToken; }
    public function setRememberToken($value)
    {
        $this->rememberToken = $value;
    }
    public function getRememberTokenName(): string { return 'remember_token'; }

    // --- getters/setters ---
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setPassword(string $password): void { $this->password = $password; }

    // --- JSON serialization ---
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
