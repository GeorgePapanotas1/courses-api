<?php

namespace Modules\Course\Core\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Course\Core\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Core\Domain\Course;

interface ICourseRepository
{
    /**
     * @return Course[]
     */
    public function all(): array;

    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function find(int $id): Course;

    public function create(CourseDataTransferObject $course): int;

    public function update(Course $course): bool;

    public function delete(int $courseId): bool;
}
