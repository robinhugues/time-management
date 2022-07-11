<?php

namespace App\Entity;


use App\Repository\ScheduleRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
#[ApiResource(
    normalizationContext:['groups' => ['schedule', 'timestamps']],
    denormalizationContext:['groups' => 'schedule:write'],
    order: ['updatedAt' => 'DESC']
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'exact', 'priority' => 'exact'])]
#[ApiFilter(DateFilter::class, properties:['startDateTime', 'endDateTime', 'updatedAt', 'createdAt'])]
class Schedule
{
    use \App\Support\Traits\EntityTimestampable; 


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['schedule'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['schedule', 'schedule:write'])]
    private $name;

    #[ORM\Column(type: 'text')]
    #[Groups(['schedule', 'schedule:write'])]
    private $comment;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['schedule', 'schedule:write'])]
    private $startDateTime;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['schedule', 'schedule:write'])]
    private $endDateTime;

    #[ORM\Column(type: 'integer')]
    #[Groups(['schedule', 'schedule:write'])]
    private $priority;

    #[ORM\ManyToOne(targetEntity: ScheduleType::class, inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['schedule', 'schedule:write'])]
    private $scheduleType;


    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTime();
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
