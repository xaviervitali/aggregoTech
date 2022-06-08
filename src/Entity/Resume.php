<?php

namespace App\Entity;

use App\Repository\ResumeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\File as FileExtension;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ResumeRepository::class)
 * @Vich\Uploadable
 */
class Resume
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $motivation;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="resume", fileNameProperty="resumeFile")
     * @FileExtension(
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "video/mp4", "video/quicktime", "video/avi", "application/pdf","application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/vnd.oasis.opendocument.text","application/vnd.ms-powerpoint","application/vnd.openxmlformats-officedocument.presentationml.presentation", "text/plain"},

     * )
     * @Assert\File(maxSize="5M")
     * @var File|null
     */
    private $uploadedFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resumeFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $extLink;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="resume", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**

     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance

     * of 'UploadedFile' is injected into this setter to trigger the  update. If this

     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter

     * must be able to accept an instance of 'File' as the bundle will inject one here

     * during Doctrine hydration.

     *

     * @param File|UploadedFile|null $UploadedFile

     */

    public function setUploadedFile(?File $uploadedFile): void
    {
        $this->uploadedFile = $uploadedFile;
        if ($this->uploadedFile) {
            $this->createdAt = new \DateTimeImmutable('now');
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

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): self
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getResumeFile(): ?string
    {
        return $this->resumeFile;
    }

    public function setResumeFile(string $resumeFile): self
    {
        $this->resumeFile = $resumeFile;

        return $this;
    }

    public function getExtLink(): ?string
    {
        return $this->extLink;
    }

    public function setExtLink(?string $extLink): self
    {
        $this->extLink = $extLink;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
