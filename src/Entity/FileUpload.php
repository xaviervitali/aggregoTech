<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FileUploadRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File as FileExtension;

/**
 * @ORM\Entity(repositoryClass=FileUploadRepository::class)
 * @Vich\Uploadable
 */
class FileUpload
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="fileUpload", fileNameProperty="fileUploadedName")
     * 
     * @FileExtension(
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "video/mp4", "video/quicktime", "video/avi", "application/pdf","application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/vnd.oasis.opendocument.text","application/vnd.ms-powerpoint","application/vnd.openxmlformats-officedocument.presentationml.presentation" ,  "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "text/plain", "application/zip"},
     *     mimeTypesMessage = "Wrong file type (jpg, gif, png, mp4, mov,avi,pdf,doc,docx,odt, ppt, pttx, xls, xlsx, txt, zip)"
     * )
     * @Groups({"file:read"})
     * @Assert\File(maxSize="1000M")
     * @var File|null
     */
    private $uploadedFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"file:read"})
    
     */
    private $fileUploadedName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"file:read"})
     
     */
    private $title;



    /**
     * @ORM\Column(type="datetime")
     * @Groups({"file:read"})
     * 
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="fileUploads")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=FileCategory::class, inversedBy="fileUploads")
     */
    private $fileCategory;


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

        if (null !== $uploadedFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
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

    public function getFileUploadedName(): ?string
    {
        return $this->fileUploadedName;
    }

    public function setFileUploadedName(?string $fileUploadedName): self
    {
        $this->fileUploadedName = $fileUploadedName;

        return $this;
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
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getFileCategory(): ?FileCategory
    {
        return $this->fileCategory;
    }

    public function setFileCategory(?FileCategory $fileCategory): self
    {
        $this->fileCategory = $fileCategory;

        return $this;
    }
}
