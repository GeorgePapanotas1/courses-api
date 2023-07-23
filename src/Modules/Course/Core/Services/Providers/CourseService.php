<?php

namespace Modules\Course\Core\Services\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Course\Core\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Core\Domain\Course;
use Modules\Course\Core\Repositories\Contracts\ICourseRepository;
use Modules\Course\Core\Services\Contracts\ICourseService;

class CourseService implements ICourseService
{
    public function __construct(
        private readonly ICourseRepository $courseRepository
    ) {
    }

    public function getAllCourses(): array
    {
        return $this->courseRepository->all();
    }

    public function getAllCoursesPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->courseRepository->paginate($perPage);
    }

    public function findCourse(int $courseId): Course
    {
        return $this->courseRepository->find($courseId);
    }

    public function createCourse(CourseDataTransferObject $course): int
    {
        return $this->courseRepository->create($course);
    }

    public function updateCourse(Course $course): bool
    {
        return $this->courseRepository->update($course);
    }

    public function deleteCourse(int $courseId): bool
    {
        return $this->courseRepository->delete($courseId);
    }
}
