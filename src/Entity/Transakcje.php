<?php

namespace App\Entity;

use App\Repository\TransakcjeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransakcjeRepository::class)]
class Transakcje
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\ManyToOne(inversedBy: 'transakcjes')]
  private ?User $user = null;

  #[ORM\Column]
  private ?int $ilosc_biletow = null;

  #[ORM\ManyToOne(inversedBy: 'bilety')]
  private Event $events;

  public function __toString(): string
  {
    return $this->id;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getIloscBiletow(): ?int
  {
    return $this->ilosc_biletow;
  }

  public function setIloscBiletow(int $ilosc_biletow): static
  {
    $this->ilosc_biletow = $ilosc_biletow;

    return $this;
  }

  public function getUser(): ?User
  {
    return $this->user;
  }

  public function setUser(?User $user): static
  {
    $this->user = $user;

    return $this;
  }

  public function getEvents(): ?Event
  {
    return $this->events;
  }

  public function setEvents(?Event $events): static
  {
    $this->events = $events;

    return $this;
  }
}
