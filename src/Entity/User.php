<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"username"}, message="Le nom d'utilisateur existe déjà")
 * @Vich\Uploadable

 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="le champs nom d'utilateur ne peut être vide")
     * @Assert\NotNull(message="le champs nom d'utilateur ne peut être vide")
     
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotNull(message="Veuillez spécifier au moins un rôle à l'utilisateur")
     
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
    * @Assert\NotNull
     * @Assert\NotBlank(message="le mot de passe ne peut être vide")
     */
    private $password;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="le prénom ne peut être vide")
     * @Assert\NotBlank(message="le prénom ne peut être vide")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="le nom ne peut être vide")
     * @Assert\NotBlank(message="le nom ne peut être vide")
     */
    private $lastname;


    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=FileUpload::class, mappedBy="user",  orphanRemoval=true)
     */
    private $fileUploads;

    /**
     * @ORM\OneToMany(targetEntity=Attendance::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $attendances;


    /**
     * @ORM\OneToMany(targetEntity=Attendance::class, mappedBy="addedBy",  cascade={"persist", "remove"})
     */
    private $attendanceOwner;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $leaveAt;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\Column(type="text",  nullable=true)
     */
    private $signature;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

 

 



   
    public function __construct()
    {
        $this->surveys = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->fields = new ArrayCollection();
        $this->fileUploads = new ArrayCollection();
        $this->attendances = new ArrayCollection();
        $this->attendanceOwner = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    /**
     * @return Collection|FileUpload[]
     */
    public function getFileUploads(): Collection
    {
        return $this->fileUploads;
    }

    public function addFileUpload(FileUpload $fileUpload): self
    {
        if (!$this->fileUploads->contains($fileUpload)) {
            $this->fileUploads[] = $fileUpload;
            $fileUpload->setUser($this);
        }

        return $this;
    }

    public function removeFileUpload(FileUpload $fileUpload): self
    {
        if ($this->fileUploads->removeElement($fileUpload)) {
            // set the owning side to null (unless already changed)
            if ($fileUpload->getUser() === $this) {
                $fileUpload->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Attendance[]
     */
    public function getAttendances(): Collection
    {
        return $this->attendances;
    }

    public function addAttendance(Attendance $attendance): self
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances[] = $attendance;
            $attendance->setUser($this);
        }

        return $this;
    }

    public function removeAttendance(Attendance $attendance): self
    {
        if ($this->attendances->removeElement($attendance)) {
            // set the owning side to null (unless already changed)
            if ($attendance->getUser() === $this) {
                $attendance->setUser(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection|Attendance[]
     */
    public function getAttendanceOwner(): Collection
    {
        return $this->attendanceOwner;
    }

    public function addAttendanceOwner(Attendance $attendanceOwner): self
    {
        if (!$this->attendanceOwner->contains($attendanceOwner)) {
            $this->attendanceOwner[] = $attendanceOwner;
            $attendanceOwner->setAddedBy($this);
        }

        return $this;
    }

    public function removeAttendanceOwner(Attendance $attendanceOwner): self
    {
        if ($this->attendanceOwner->removeElement($attendanceOwner)) {
            // set the owning side to null (unless already changed)
            if ($attendanceOwner->getAddedBy() === $this) {
                $attendanceOwner->setAddedBy(null);
            }
        }

        return $this;
    }
    function __toString()
    {
        return $this->username;
    }

    public function getLeaveAt(): ?\DateTimeImmutable
    {
        return $this->leaveAt;
    }

    public function setLeaveAt(?\DateTimeImmutable $leaveAt): self
    {
        $this->leaveAt = $leaveAt;

        return $this;
    }

  
    
    public function haveRole($role){
       
            return in_array($role, $this->getRoles());
      
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }



    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


}
