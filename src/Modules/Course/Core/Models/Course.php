<?php

namespace Modules\Course\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Core\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Core\Domain\Course as CourseEntity;
use Modules\Course\Core\Enums\CourseStatusEnum;

class Course extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => CourseStatusEnum::class,
    ];

    public function toDto(): CourseDataTransferObject
    {
        return CourseDataTransferObject::build()
            ->setTitle($this->title)
            ->setDescription($this->description)
            ->setStatus($this->status)
            ->setIsPremium($this->is_premium);
    }

    public function toCourseEntity(): CourseEntity
    {
        return new CourseEntity(
            id: $this->id,
            title: $this->title,
            description: $this->description,
            status: $this->status,
            isPremium: $this->is_premium,
            createdAt: $this->created_at,
            updatedAt: $this->updated_at
        );
    }
}
