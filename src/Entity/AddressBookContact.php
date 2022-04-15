<?php

namespace App\Entity;

use App\Repository\AddressBookContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AddressBookContactRepository::class)
 */
class AddressBookContact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *  @Groups({"group1"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"group1"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"group1"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"group1"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"group1"})
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity=AddressBook::class, inversedBy="contacts")
     */
    private $addressBook;

    /**
     * @ORM\OneToMany(targetEntity=Survey::class, mappedBy="contact")
     */
    private $surveys;

    public function __construct()
    {
        $this->surveys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getAddressBook(): ?AddressBook
    {
        return $this->addressBook;
    }

    public function setAddressBook(?AddressBook $addressBook): self
    {
        $this->addressBook = $addressBook;

        return $this;
    }

    /**
     * @return Collection|Survey[]
     */
    public function getSurveys(): Collection
    {
        return $this->surveys;
    }

    public function addSurvey(Survey $survey): self
    {
        if (!$this->surveys->contains($survey)) {
            $this->surveys[] = $survey;
            $survey->setContact($this);
        }

        return $this;
    }

    public function removeSurvey(Survey $survey): self
    {
        if ($this->surveys->removeElement($survey)) {
            // set the owning side to null (unless already changed)
            if ($survey->getContact() === $this) {
                $survey->setContact(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
