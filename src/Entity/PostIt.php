<?php

namespace App\Entity;

use App\Repository\PostItRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PostItRepository::class)
 */
class PostIt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups("postIt")]
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups("postIt")]
    private $createdAt;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups("postIt")]
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="employee")
     */
    #[Groups("postIt")]
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="postIts")
     */
    private $employee;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups("postIt")]
    private $category;



    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getEmployee(): ?User
    {
        return $this->employee;
    }

    public function setEmployee(?User $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }
}
