<?php

namespace Modules\Course\Services;

use Modules\Course\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Repositories\Contracts\ICourseRepository;

class CourseService
{
    public function __construct(
        private readonly ICourseRepository $courseRepository
    ) {
    }

    public function getAllCourses(): array
    {
        return $this->courseRepository->all();
    }

    public function findCourse(int $courseId): CourseDataTransferObject
    {
        return $this->courseRepository->find($courseId);
    }

    public function createCourse(CourseDataTransferObject $course): int
    {
        return $this->courseRepository->create($course);
    }

    public function updateCourse(CourseDataTransferObject $course): bool
    {
        return $this->courseRepository->update($course);
    }

    public function deleteCourse(int $courseId): bool
    {
        return $this->courseRepository->delete($courseId);
    }
}
