<?php

namespace Modules\Course\DataTransferObjects;

use Carbon\Carbon;
use Modules\Course\Enums\CourseStatusEnum;

class CourseDataTransferObject
{
    private ?int $id = null;

    private string $title;

    private string $description;

    private CourseStatusEnum $status;

    private bool $isPremium;

    private ?Carbon $createdAt = null;

    private ?Carbon $updatedAt = null;

    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): CourseDataTransferObject
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): CourseDataTransferObject
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): CourseDataTransferObject
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): CourseStatusEnum
    {
        return $this->status;
    }

    public function setStatus(CourseStatusEnum $status): CourseDataTransferObject
    {
        $this->status = $status;

        return $this;
    }

    public function isPremium(): bool
    {
        return $this->isPremium;
    }

    public function setIsPremium(bool $isPremium): CourseDataTransferObject
    {
        $this->isPremium = $isPremium;

        return $this;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?Carbon $createdAt): CourseDataTransferObject
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?Carbon $updatedAt): CourseDataTransferObject
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'status' => $this->getStatus()->value,
            'is_premium' => $this->isPremium(),
            'added' => $this->getCreatedAt(),
            'modified' => $this->getUpdatedAt(),
        ];
    }
}
