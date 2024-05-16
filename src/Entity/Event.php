<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $miasto = null;

  #[ORM\Column]
  private ?float $cena = null;

  #[ORM\Column(type: Types::TEXT)]
  private ?string $opis = null;

  #[ORM\Column]
  private ?int $ilosc = null;

  /**
   * @var Collection<int, Transakcje>
   */
  #[ORM\OneToMany(targetEntity: Transakcje::class, mappedBy: 'events')]
  private Collection $bilety;


  public function __construct()
  {
    $this->bilety = new ArrayCollection();
  }

  public function __toString(): string
  {
    return $this->miasto;
  }

  public function getId(): ?int
  {
      return $this->id;
  }

  public function getMiasto(): ?string
  {
      return $this->miasto;
  }

  public function setMiasto(string $miasto): static
  {
      $this->miasto = $miasto;

      return $this;
  }

  public function getCena(): ?float
  {
      return $this->cena;
  }

  public function setCena(float $cena): static
  {
      $this->cena = $cena;

      return $this;
  }

  public function getOpis(): ?string
  {
      return $this->opis;
  }

  public function setOpis(string $opis): static
  {
      $this->opis = $opis;

      return $this;
  }

  public function getIlosc(): ?int
  {
      return $this->ilosc;
  }

  public function setIlosc(int $ilosc): static
  {
      $this->ilosc = $ilosc;

      return $this;
  }

  /**
   * @return Collection<int, Transakcje>
   */
  public function getBilety(): Collection
  {
      return $this->bilety;
  }

  public function addBilety(Transakcje $bilety): static
  {
      if (!$this->bilety->contains($bilety)) {
          $this->bilety->add($bilety);
          $bilety->setEvents($this);
      }

      return $this;
  }

  public function removeBilety(Transakcje $bilety): static
  {
      if ($this->bilety->removeElement($bilety)) {
          // set the owning side to null (unless already changed)
          if ($bilety->getEvents() === $this) {
              $bilety->setEvents(null);
          }
      }

      return $this;
  }
}
