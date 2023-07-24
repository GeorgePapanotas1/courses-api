<?php

namespace Modules\Course\Core\Services\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Course\Core\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Core\Domain\Course;
use Modules\Course\Core\Exceptions\CourseNotCreatedException;

interface ICourseService
{
    public function getAllCourses(): array;

    public function getAllCoursesPaginated(int $perPage = 10): LengthAwarePaginator;

    public function findCourse(int $courseId): Course;

    /**
     * @throws CourseNotCreatedException
     */
    public function createCourse(CourseDataTransferObject $course): int;

    public function updateCourse(Course $course): bool;

    public function deleteCourse(int $courseId): bool;
}
