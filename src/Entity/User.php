<?php



namespace App\Entity;



use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\File;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\File as FileExtension;



/**

 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @Vich\Uploadable
 * @UniqueEntity(fields={"username"}, message="Le nom d'utilisateur existe déjà")

 */

class User implements UserInterface, PasswordAuthenticatedUserInterface, \Serializable

{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     *  @Groups({"user"})
     * @ORM\Column(type="integer")
     */
    #[Groups("postIt")]

    private $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="avatar", fileNameProperty="avatar")
     * @FileExtension(
     *     mimeTypes = {"image/*"},
     * )
     * @Assert\File(maxSize="1M")
     * @var File|null
     */
    private $uploadedFile;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="le champs nom d'utilateur ne peut être vide")
     *  @Groups({"user"})
     * @Assert\NotNull(message="le champs nom d'utilateur ne peut être vide")
     *
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotNull(message="Veuillez spécifier au moins un rôle à l'utilisateur")
     *  @Groups({"user"})
     * 
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
     *  @Groups({"holiday", "user"})
     */
    #[Groups("postIt")]

    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="le nom ne peut être vide")
     * @Assert\NotBlank(message="le nom ne peut être vide")
     *  @Groups({"holiday", "user"})
     */
    #[Groups("postIt")]

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
     *  @Groups({"user"})
     * @ORM\Column(type="text",  nullable=true)
     */
    private $signature;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Survey::class, mappedBy="user")
     */
    private $surveys;

    /**
     * @ORM\OneToMany(targetEntity=Holiday::class, mappedBy="user")
     */
    private $holidays;

    /**
     * @ORM\OneToMany(targetEntity=Holiday::class, mappedBy="acceptedBy")
     */
    private $holidayAccepted;

    /**
     * @ORM\OneToMany(targetEntity=Statement::class, mappedBy="user")
     */
    private $statements;



    /**
     * @ORM\OneToMany(targetEntity=Statement::class, mappedBy="managerComment")
     */
    private $managerStatements;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=Resume::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $resume;

    /**
     * @ORM\OneToMany(targetEntity=PostIt::class, mappedBy="createdBy")
     */
    private $postIts;





    public function __construct()
    {

        $this->surveys = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->fields = new ArrayCollection();
        $this->fileUploads = new ArrayCollection();
        $this->attendances = new ArrayCollection();
        $this->attendanceOwner = new ArrayCollection();
        $this->holidays = new ArrayCollection();
        $this->holidayAccepted = new ArrayCollection();
        $this->statements = new ArrayCollection();
        $this->statementComments = new ArrayCollection();
        $this->managerStatements = new ArrayCollection();
        $this->employee = new ArrayCollection();
        $this->postIts = new ArrayCollection();
    }


    /**

     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance

     * of 'UploadedFile' is injected into this setter to trigger the  update. If this

     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter

     * must be able to accept an instance of 'File' as the bundle will inject one here

     * during Doctrine hydration.

     *

     * @param File|UploadedFile|null $UploadedFile

     */

    public function setUploadedFile(?File $uploadedFile = null): void

    {
        $this->uploadedFile = $uploadedFile;

        if ($this->uploadedFile) {
            $this->updatedAt = new \DateTimeImmutable('now');
        }
    }



    public function getUploadedFile(): ?File

    {

        return $this->uploadedFile;
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







    public function haveRole($role)

    {



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



    public function getAvatar(): ?string

    {

        return $this->avatar;
    }



    public function setAvatar(?string $avatar): self

    {

        $this->avatar = $avatar;



        return $this;
    }



    public function serialize()

    {

        return serialize(array(

            $this->id,

            $this->username,

            $this->password,



            // see section on salt below

            // $this->salt,

        ));
    }



    public function unserialize($serialized)

    {

        list(

            $this->id,

            $this->username,

            $this->password,

            // see section on salt below

            // $this->salt

        ) = unserialize($serialized);
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
            $survey->setUser($this);
        }

        return $this;
    }

    public function removeSurvey(Survey $survey): self
    {
        if ($this->surveys->removeElement($survey)) {
            // set the owning side to null (unless already changed)
            if ($survey->getUser() === $this) {
                $survey->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Holiday[]
     */
    public function getHolidays(): Collection
    {
        return $this->holidays;
    }

    public function addHoliday(Holiday $holiday): self
    {
        if (!$this->holidays->contains($holiday)) {
            $this->holidays[] = $holiday;
            $holiday->setUser($this);
        }

        return $this;
    }

    public function removeHoliday(Holiday $holiday): self
    {
        if ($this->holidays->removeElement($holiday)) {
            // set the owning side to null (unless already changed)
            if ($holiday->getUser() === $this) {
                $holiday->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Holiday[]
     */
    public function getHolidayAccepted(): Collection
    {
        return $this->holidayAccepted;
    }

    public function addHolidayAccepted(Holiday $holidayAccepted): self
    {
        if (!$this->holidayAccepted->contains($holidayAccepted)) {
            $this->holidayAccepted[] = $holidayAccepted;
            $holidayAccepted->setManager($this);
        }

        return $this;
    }

    public function removeHolidayAccepted(Holiday $holidayAccepted): self
    {
        if ($this->holidayAccepted->removeElement($holidayAccepted)) {
            // set the owning side to null (unless already changed)
            if ($holidayAccepted->getManager() === $this) {
                $holidayAccepted->setManager(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Statement[]
     */
    public function getStatements(): Collection
    {
        return $this->statements;
    }

    public function addStatement(Statement $statement): self
    {
        if (!$this->statements->contains($statement)) {
            $this->statements[] = $statement;
            $statement->setUser($this);
        }

        return $this;
    }

    public function removeStatement(Statement $statement): self
    {
        if ($this->statements->removeElement($statement)) {
            // set the owning side to null (unless already changed)
            if ($statement->getUser() === $this) {
                $statement->setUser(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function setResume(?Resume $resume): self
    {
        // unset the owning side of the relation if necessary
        if ($resume === null && $this->resume !== null) {
            $this->resume->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($resume !== null && $resume->getUser() !== $this) {
            $resume->setUser($this);
        }

        $this->resume = $resume;

        return $this;
    }

    /**
     * @return Collection<int, PostIt>
     */
    public function getPostIt(): Collection
    {
        return $this->employee;
    }

    public function addPostIt(PostIt $postIts): self
    {
        if (!$this->postIts->contains($postIts)) {
            $this->postIts[] = $postIts;
            $postIts->setCreatedBy($this);
        }

        return $this;
    }

    public function removePostIt(PostIt $postIts): self
    {
        if ($this->postIts->removeElement($postIts)) {
            // set the owning side to null (unless already changed)
            if ($postIts->getCreatedBy() === $this) {
                $postIts->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostIt>
     */
    public function getPostIts(): Collection
    {
        return $this->postIts;
    }
}
