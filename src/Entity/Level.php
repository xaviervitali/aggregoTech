<?php

namespace App\Entity;

use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LevelRepository::class)
 */
class Level
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *   @Groups({"statement"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *   @Groups({"statement"})
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Appreciation::class, mappedBy="level")
     */
    private $appreciations;

    public function __construct()
    {
        $this->appreciations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Appreciation[]
     */
    public function getAppreciations(): Collection
    {
        return $this->appreciations;
    }

    public function addAppreciation(Appreciation $appreciation): self
    {
        if (!$this->appreciations->contains($appreciation)) {
            $this->appreciations[] = $appreciation;
            $appreciation->setLevel($this);
        }

        return $this;
    }

    public function removeAppreciation(Appreciation $appreciation): self
    {
        if ($this->appreciations->removeElement($appreciation)) {
            // set the owning side to null (unless already changed)
            if ($appreciation->getLevel() === $this) {
                $appreciation->setLevel(null);
            }
        }

        return $this;
    }
}
