<?php

namespace Modules\Course\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Course\DataTransferObjects\CourseDataTransferObject;

interface ICourseRepository
{
    public function all(): array;

    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function find(int $id): CourseDataTransferObject;

    public function create(CourseDataTransferObject $course): int;

    public function update(CourseDataTransferObject $course): bool;

    public function delete(int $courseId): bool;
}
