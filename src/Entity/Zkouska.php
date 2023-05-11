<?php

namespace App\Entity;

use App\Repository\ZkouskaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZkouskaRepository::class)]
class Zkouska
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $jmeno = null;

    #[ORM\Column(length: 255)]
    private ?string $informace = null;

    #[ORM\Column(length: 255)]
    private ?string $height = null;

    #[ORM\Column(length: 255)]
    private ?string $weight = null;

    #[ORM\Column]
    private ?bool $frajer = null;

    #[ORM\Column]
    private ?bool $smradoch = null;

    #[ORM\Column(length: 500)]
    private ?string $img = null;

    #[ORM\Column()]
    private ?int $hodnoceni = 0;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datum = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJmeno(): ?string
    {
        return $this->jmeno;
    }

    public function setjmeno(string $jmeno): self
    {
        $this->jmeno = $jmeno;

        return $this;
    }

    public function getInformace(): ?string
    {
        return $this->informace;
    }

    public function setinformace(string $informace): self
    {
        $this->informace = $informace;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function isFrajer(): ?bool
    {
        return $this->frajer;
    }

    public function setFrajer(bool $frajer): self
    {
        $this->frajer = $frajer;

        return $this;
    }

    public function isSmradoch(): ?bool
    {
        return $this->smradoch;
    }

    public function setSmradoch(bool $smradoch): self
    {
        $this->smradoch = $smradoch;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getHodnoceni(): ?int
    {
        return $this->hodnoceni;
    }

    public function setHodnoceni(int $hodnoceni): self
    {
        $this->hodnoceni = $hodnoceni;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(?\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }
}
