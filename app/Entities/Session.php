<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'sessions')]
class Session
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    private string $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $userId = null;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private ?string $ipAddress = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $userAgent = null;

    #[ORM\Column(type: 'text')]
    private string $payload;

    #[ORM\Column(type: 'integer')]
    private int $lastActivity;

    /**
     * @param int|null $userId
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @param string $payload
     * @param int $lastActivity
     */
    public function __construct(?int $userId, ?string $ipAddress, ?string $userAgent, string $payload, int $lastActivity)
    {
        $this->userId = $userId;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
        $this->payload = $payload;
        $this->lastActivity = $lastActivity;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Session
     */
    public function setId(string $id): Session
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     * @return Session
     */
    public function setUserId(?int $userId): Session
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    /**
     * @param string|null $ipAddress
     * @return Session
     */
    public function setIpAddress(?string $ipAddress): Session
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    /**
     * @param string|null $userAgent
     * @return Session
     */
    public function setUserAgent(?string $userAgent): Session
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     * @return Session
     */
    public function setPayload(string $payload): Session
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return int
     */
    public function getLastActivity(): int
    {
        return $this->lastActivity;
    }

    /**
     * @param int $lastActivity
     * @return Session
     */
    public function setLastActivity(int $lastActivity): Session
    {
        $this->lastActivity = $lastActivity;
        return $this;
    }


}
