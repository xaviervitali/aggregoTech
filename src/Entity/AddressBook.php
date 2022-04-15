<?php

namespace App\Entity;

use App\Repository\AddressBookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=AddressBookRepository::class)
 */
class AddressBook
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"group1"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group1"})
     */
    private $companyName;



    /**
     * @ORM\Column(type="text")
     * @Groups({"group1"})
     
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=AddressBookActivity::class, mappedBy="company")
     * @Groups({"group1"})
     */
    private $addressBookActivities;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"group1"})
     
     */
    private $address;

    /**
     * @Groups({"group1"})
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\OneToMany(targetEntity=AddressBookContact::class, mappedBy="addressBook", cascade={"persist", "remove"})
     * @Groups({"group1"})
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity=Survey::class, mappedBy="addressBook")
     */
    private $surveys;

    public function __construct()
    {
        $this->addressBookActivities = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->surveys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    // public function getContact(): ?string
    // {
    //     return $this->contact;
    // }

    // public function setContact(string $contact): self
    // {
    //     $this->contact = $contact;

    //     return $this;
    // }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|AddressBookActivity[]
     */
    public function getAddressBookActivities(): Collection
    {
        return $this->addressBookActivities;
    }

    public function addAddressBookActivity(AddressBookActivity $addressBookActivity): self
    {
        if (!$this->addressBookActivities->contains($addressBookActivity)) {
            $this->addressBookActivities[] = $addressBookActivity;
            $addressBookActivity->addCompany($this);
        }

        return $this;
    }

    public function removeAddressBookActivity(AddressBookActivity $addressBookActivity): self
    {
        if ($this->addressBookActivities->removeElement($addressBookActivity)) {
            $addressBookActivity->removeCompany($this);
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return Collection|AddressBookContact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(AddressBookContact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setAddressBook($this);
        }

        return $this;
    }

    public function removeContact(AddressBookContact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getAddressBook() === $this) {
                $contact->setAddressBook(null);
            }
        }

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
            $survey->setAddressBook($this);
        }

        return $this;
    }

    public function removeSurvey(Survey $survey): self
    {
        if ($this->surveys->removeElement($survey)) {
            // set the owning side to null (unless already changed)
            if ($survey->getAddressBook() === $this) {
                $survey->setAddressBook(null);
            }
        }

        return $this;
    }
}
