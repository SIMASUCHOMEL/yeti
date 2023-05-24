<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?int $frajer = null;

    #[ORM\Column]
    private ?int $smradoch = null;

    #[ORM\Column]
    private ?int $chytrak = null;

    #[ORM\Column]
    private ?int $slusnak = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFrajer(): ?int
    {
        return $this->frajer;
    }

    public function setFrajer(int $frajer): self
    {
        $this->frajer = $frajer;

        return $this;
    }

    public function getSmradoch(): ?int
    {
        return $this->smradoch;
    }

    public function setSmradoch(int $smradoch): self
    {
        $this->smradoch = $smradoch;

        return $this;
    }

    public function getChytrak(): ?int
    {
        return $this->chytrak;
    }

    public function setChytrak(int $chytrak): self
    {
        $this->chytrak = $chytrak;

        return $this;
    }

    public function getSlusnak(): ?int
    {
        return $this->slusnak;
    }

    public function setSlusnak(int $slusnak): self
    {
        $this->slusnak = $slusnak;

        return $this;
    }
}
