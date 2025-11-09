<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'Adventure')]
#[ORM\HasLifecycleCallbacks]
class Adventure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "assessments")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private User $user;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'smallint')]
    private int $maxPlayers;

    #[ORM\Column(type: 'boolean')]
    private string $isPrivate;

    #[ORM\Column(type: 'boolean')]
    private string $isActive;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $createdAt;
    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $updatedAt;

    /**
     * @param User $user
     * @param string $title
     * @param string $description
     * @param int $maxPlayers
     * @param string $isPrivate
     * @param string $isActive
     */
    public function __construct(User $user, string $title, string $description, int $maxPlayers, string $isPrivate, string $isActive)
    {
        $this->user = $user;
        $this->title = $title;
        $this->description = $description;
        $this->maxPlayers = $maxPlayers;
        $this->isPrivate = $isPrivate;
        $this->isActive = $isActive;
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
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Adventure
     */
    public function setUser(User $user): Adventure
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Adventure
     */
    public function setTitle(string $title): Adventure
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Adventure
     */
    public function setDescription(string $description): Adventure
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxPlayers(): int
    {
        return $this->maxPlayers;
    }

    /**
     * @param int $maxPlayers
     * @return Adventure
     */
    public function setMaxPlayers(int $maxPlayers): Adventure
    {
        $this->maxPlayers = $maxPlayers;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsPrivate(): string
    {
        return $this->isPrivate;
    }

    /**
     * @param string $isPrivate
     * @return Adventure
     */
    public function setIsPrivate(string $isPrivate): Adventure
    {
        $this->isPrivate = $isPrivate;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsActive(): string
    {
        return $this->isActive;
    }

    /**
     * @param string $isActive
     * @return Adventure
     */
    public function setIsActive(string $isActive): Adventure
    {
        $this->isActive = $isActive;
        return $this;
    }



    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return Adventure
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): Adventure
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface $updatedAt
     * @return Adventure
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): Adventure
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

}
