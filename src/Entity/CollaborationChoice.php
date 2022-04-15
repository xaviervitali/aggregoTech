<?php

namespace App\Entity;

use App\Repository\CollaborationChoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CollaborationChoiceRepository::class)
 */
class CollaborationChoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Collaboration::class, mappedBy="collaborationChoice")
     */
    private $collaboration;

    public function __construct()
    {
        $this->collaboration = new ArrayCollection();
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
     * @return Collection|Collaboration[]
     */
    public function getCollaboration(): Collection
    {
        return $this->collaboration;
    }

    public function addCollaboration(Collaboration $collaboration): self
    {
        if (!$this->collaboration->contains($collaboration)) {
            $this->collaboration[] = $collaboration;
            $collaboration->setCollaborationChoice($this);
        }

        return $this;
    }

    public function removeCollaboration(Collaboration $collaboration): self
    {
        if ($this->collaboration->removeElement($collaboration)) {
            // set the owning side to null (unless already changed)
            if ($collaboration->getCollaborationChoice() === $this) {
                $collaboration->setCollaborationChoice(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}
