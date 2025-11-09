<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'personal_access_tokens')]
class PersonalAccessToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tokens')]
    #[ORM\JoinColumn(name: 'tokenable_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private User $tokenable;

    #[ORM\Column(type: 'string', length: 255)]
    private string $tokenableType = User::class;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 64, unique: true)]
    private string $token;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $abilities = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lastUsedAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $expiresAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    // getters / setters omitted for brevity

    /**
     * @param User $tokenable
     * @param string $tokenableType
     * @param string $name
     * @param string|null $abilities
     * @param string $token
     * @param \DateTimeInterface|null $lastUsedAt
     * @param \DateTimeInterface|null $expiresAt
     * @param \DateTimeInterface|null $createdAt
     * @param \DateTimeInterface|null $updatedAt
     */
    public function __construct(User $tokenable, string $tokenableType, string $name, ?string $abilities, string $token, ?\DateTimeInterface $lastUsedAt, ?\DateTimeInterface $expiresAt, ?\DateTimeInterface $createdAt, ?\DateTimeInterface $updatedAt)
    {
        $this->tokenable = $tokenable;
        $this->tokenableType = $tokenableType;
        $this->name = $name;
        $this->abilities = $abilities;
        $this->token = $token;
        $this->lastUsedAt = $lastUsedAt;
        $this->expiresAt = $expiresAt;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getTokenable(): User
    {
        return $this->tokenable;
    }

    /**
     * @param User $tokenable
     * @return PersonalAccessToken
     */
    public function setTokenable(User $tokenable): PersonalAccessToken
    {
        $this->tokenable = $tokenable;
        return $this;
    }

    /**
     * @return string
     */
    public function getTokenableType(): string
    {
        return $this->tokenableType;
    }

    /**
     * @param string $tokenableType
     * @return PersonalAccessToken
     */
    public function setTokenableType(string $tokenableType): PersonalAccessToken
    {
        $this->tokenableType = $tokenableType;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PersonalAccessToken
     */
    public function setName(string $name): PersonalAccessToken
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return PersonalAccessToken
     */
    public function setToken(string $token): PersonalAccessToken
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAbilities(): ?string
    {
        return $this->abilities;
    }

    /**
     * @param string|null $abilities
     * @return PersonalAccessToken
     */
    public function setAbilities(?string $abilities): PersonalAccessToken
    {
        $this->abilities = $abilities;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getLastUsedAt(): ?\DateTimeInterface
    {
        return $this->lastUsedAt;
    }

    /**
     * @param \DateTimeInterface|null $lastUsedAt
     * @return PersonalAccessToken
     */
    public function setLastUsedAt(?\DateTimeInterface $lastUsedAt): PersonalAccessToken
    {
        $this->lastUsedAt = $lastUsedAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    /**
     * @param \DateTimeInterface|null $expiresAt
     * @return PersonalAccessToken
     */
    public function setExpiresAt(?\DateTimeInterface $expiresAt): PersonalAccessToken
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface|null $createdAt
     * @return PersonalAccessToken
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): PersonalAccessToken
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     * @return PersonalAccessToken
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): PersonalAccessToken
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }




}
