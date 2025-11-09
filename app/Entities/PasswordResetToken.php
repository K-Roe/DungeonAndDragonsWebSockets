<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'password_reset_tokens')]
class PasswordResetToken
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $token;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    /**
     * @param string $token
     * @param \DateTimeInterface|null $createdAt
     * @param string $email
     */
    public function __construct(string $token, ?\DateTimeInterface $createdAt, string $email)
    {
        $this->token = $token;
        $this->createdAt = $createdAt;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return PasswordResetToken
     */
    public function setEmail(string $email): PasswordResetToken
    {
        $this->email = $email;
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
     * @return PasswordResetToken
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): PasswordResetToken
    {
        $this->createdAt = $createdAt;
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
     * @return PasswordResetToken
     */
    public function setToken(string $token): PasswordResetToken
    {
        $this->token = $token;
        return $this;
    }





}
