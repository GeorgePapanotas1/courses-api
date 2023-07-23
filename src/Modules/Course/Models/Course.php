<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Enums\CourseStatusEnum;

class Course extends Model
{
    //    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => CourseStatusEnum::class,
    ];

    public function toDto(): CourseDataTransferObject
    {
        return CourseDataTransferObject::build()
            ->setId($this->id ?? null)
            ->setTitle($this->title)
            ->setDescription($this->description)
            ->setStatus($this->status)
            ->setIsPremium($this->is_premium)
            ->setCreatedAt($this->created_at ?? null)
            ->setUpdatedAt($this->updated_at ?? null);
    }
}
