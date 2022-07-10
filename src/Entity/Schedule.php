<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
#[ApiResource(
    normalizationContext:['groups' => ['schedule', 'timestamps']],
    denormalizationContext:['groups' => 'schedule:write']
)]
class Schedule
{
    use \App\Support\Traits\EntityTimestampable; 


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text')]
    private $comment;

    #[ORM\Column(type: 'datetime')]
    private $startDateTime;

    #[ORM\Column(type: 'datetime')]
    private $endDateTime;

    #[ORM\Column(type: 'integer')]
    private $priority;

    #[ORM\ManyToOne(targetEntity: ScheduleType::class, inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    private $scheduleType;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getStartDateTime(): ?\DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(\DateTimeInterface $startDateTime): self
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getEndDateTime(): ?\DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(\DateTimeInterface $endDateTime): self
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getScheduleType(): ?ScheduleType
    {
        return $this->scheduleType;
    }

    public function setScheduleType(?ScheduleType $scheduleType): self
    {
        $this->scheduleType = $scheduleType;

        return $this;
    }
}
