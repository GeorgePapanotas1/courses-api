<?php

namespace Modules\Course\Core\Domain;

use Carbon\Carbon;
use Modules\Course\Core\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Core\Enums\CourseStatusEnum;

class Course
{
    public function __construct(
        private ?int $id,
        private string $title,
        private string $description,
        private CourseStatusEnum $status,

        private bool $isPremium,

        private ?Carbon $createdAt,

        private ?Carbon $updatedAt,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Course
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Course
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Course
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): CourseStatusEnum
    {
        return $this->status;
    }

    public function setStatus(CourseStatusEnum $status): Course
    {
        $this->status = $status;

        return $this;
    }

    public function isPremium(): bool
    {
        return $this->isPremium;
    }

    public function setIsPremium(bool $isPremium): Course
    {
        $this->isPremium = $isPremium;

        return $this;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?Carbon $createdAt): Course
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?Carbon $updatedAt): Course
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function mapToDto(): CourseDataTransferObject
    {
        return CourseDataTransferObject::build()
            ->setTitle($this->title)
            ->setDescription($this->description)
            ->setStatus($this->status)
            ->setIsPremium($this->isPremium);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
            'is_premium' => $this->isPremium,
            'added' => $this->createdAt,
            'modified' => $this->updatedAt,
        ];
    }
}
