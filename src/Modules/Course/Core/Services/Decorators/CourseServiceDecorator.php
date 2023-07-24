<?php

namespace Modules\Course\Core\Services\Decorators;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Course\Core\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Core\Domain\Course;
use Modules\Course\Core\Services\Contracts\ICourseService;

/*
 * This is out of scope. Experimenting with decorators.
 */
class CourseServiceDecorator implements ICourseService
{
    public function __construct(
        private readonly ICourseService $decoratedCourseService)
    {
    }

    public function getAllCourses(): array
    {
        return $this->decoratedCourseService->getAllCourses();
    }

    public function getAllCoursesPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->decoratedCourseService->getAllCoursesPaginated($perPage);
    }

    public function findCourse(int $courseId): Course
    {
        return $this->decoratedCourseService->findCourse($courseId);
    }

    public function createCourse(CourseDataTransferObject $course): int
    {
        return $this->decoratedCourseService->createCourse($course);
    }

    public function updateCourse(Course $course): bool
    {
        return $this->decoratedCourseService->updateCourse($course);
    }

    public function deleteCourse(int $courseId): bool
    {
        return $this->decoratedCourseService->deleteCourse($courseId);
    }
}
