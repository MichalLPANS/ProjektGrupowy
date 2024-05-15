<?php

namespace App\Entity;

use App\Repository\TransakcjeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

  /**
   * @var Collection<int, Event>
   */
  #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'bilety')]
  private Collection $events;

  public function __construct()
  {
      $this->events = new ArrayCollection();
  }

  public function __toString(): string
  {
    return $this->id;
  }

  public function getId(): ?int
  {
    return $this->id;
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

  public function getIloscBiletow(): ?int
  {
    return $this->ilosc_biletow;
  }

  public function setIloscBiletow(int $ilosc_biletow): static
  {
    $this->ilosc_biletow = $ilosc_biletow;

    return $this;
  }

  /**
   * @return Collection<int, Event>
   */
  public function getEvents(): Collection
  {
      return $this->events;
  }

  public function addEvent(Event $event): static
  {
      if (!$this->events->contains($event)) {
          $this->events->add($event);
          $event->addBilety($this);
      }

      return $this;
  }

  public function removeEvent(Event $event): static
  {
      if ($this->events->removeElement($event)) {
          $event->removeBilety($this);
      }

      return $this;
  }
}
