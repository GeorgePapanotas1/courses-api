<?php

namespace Modules\Course\Core\DataTransferObjects;

use Modules\Course\Core\Enums\CourseStatusEnum;

class CourseDataTransferObject
{
    private string $title;

    private string $description;

    private CourseStatusEnum $status;

    private bool $isPremium;

    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self;
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

    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'status' => $this->getStatus()->value,
            'is_premium' => $this->isPremium(),
        ];
    }
}
