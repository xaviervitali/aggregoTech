<?php

namespace App\Entity;

use App\Repository\StatementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatementRepository::class)
 */
class Statement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Appreciation::class, mappedBy="statement")
     */
    private $appreciations;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="statements")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=StatementComment::class, inversedBy="statements")
     */
    private $userComment;

    /**
     * @ORM\ManyToOne(targetEntity=StatementComment::class, inversedBy="managerStatements")
     */
    private $managerComment;

    public function __construct()
    {
        $this->appreciations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $appreciation->setStatement($this);
        }

        return $this;
    }

    public function removeAppreciation(Appreciation $appreciation): self
    {
        if ($this->appreciations->removeElement($appreciation)) {
            // set the owning side to null (unless already changed)
            if ($appreciation->getStatement() === $this) {
                $appreciation->setStatement(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUserComment(): ?StatementComment
    {
        return $this->userComment;
    }

    public function setUserComment(?StatementComment $userComment): self
    {
        $this->userComment = $userComment;

        return $this;
    }

    public function getManagerComment(): ?StatementComment
    {
        return $this->managerComment;
    }

    public function setManagerComment(?StatementComment $managerComment): self
    {
        $this->managerComment = $managerComment;

        return $this;
    }
}
