<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ScheduleTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ScheduleTypeRepository::class)]
#[ApiResource(
    normalizationContext:['groups' => ['schedule-type', 'timestamps']],
    denormalizationContext:['groups' => 'schedule-type:write']
)]
class ScheduleType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['schedule-type'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['schedule-type', 'schedule-type:write'])]
    private $name;

    #[ORM\OneToMany(mappedBy: 'scheduleType', targetEntity: Schedule::class)]
    private $schedules;

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
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

    /**
     * @return Collection<int, Schedule>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedule $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules[] = $schedule;
            $schedule->setScheduleType($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): self
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getScheduleType() === $this) {
                $schedule->setScheduleType(null);
            }
        }

        return $this;
    }
}
