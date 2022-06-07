<?php

namespace App\Entity;

use App\Repository\HolidayRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=HolidayRepository::class)
 */
class Holiday
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *  @Groups({"holiday"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     *  @Groups({"holiday"})
     * 
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     *  @Groups({"holiday"})
     * 
     */
    private $endDate;

    /**
     * @ORM\Column(type="date")
     *  @Groups({"holiday"})
     * 
     */
    private $restartAt;

    /**
     * @ORM\Column(type="integer")
     *  @Groups({"holiday"})
     * 
     */
    private $days;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=HolidayReason::class, inversedBy="holidays")
     */
    private $holidayReason;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="holidays")
     *  @Groups({"holiday"})
     * 
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable="true")
     *  @Groups({"holiday"})
     * 
     */
    private $status;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $acceptedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="holidayAccepted")
     */
    private $manager;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getRestartAt(): ?\DateTimeInterface
    {
        return $this->restartAt;
    }

    public function setRestartAt(\DateTimeInterface $restartAt): self
    {
        $this->restartAt = $restartAt;

        return $this;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }

    public function setDays(int $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getHolidayReason(): ?HolidayReason
    {
        return $this->holidayReason;
    }

    public function setHolidayReason(?HolidayReason $holidayReason): self
    {
        $this->holidayReason = $holidayReason;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?Boolean $status): self
    {
        $this->status = $status;

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

    public function getAcceptedAt(): ?\DateTimeImmutable
    {
        return $this->acceptedAt;
    }

    public function setAcceptedAt(\DateTimeImmutable $acceptedAt): self
    {
        $this->acceptedAt = $acceptedAt;

        return $this;
    }

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): self
    {
        $this->manager = $manager;

        return $this;
    }
}
