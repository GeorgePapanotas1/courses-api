<?php

namespace Modules\Course\Core\Repositories\Eloquent;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Course\Core\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Core\Domain\Course as CourseEntity;
use Modules\Course\Core\Models\Course;
use Modules\Course\Core\Repositories\Contracts\ICourseRepository;

class CourseRepository implements ICourseRepository
{
    public function all(): array
    {
        return Course::all()
            ->map(fn (Course $course) => $course->toCourseEntity())
            ->toArray();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        $courses = Course::paginate($perPage);

        return new LengthAwarePaginator(
            $courses->map(fn (Course $course) => $course->toCourseEntity()),
            $courses->total(),
            $courses->perPage(),
            $courses->currentPage()
        );
    }

    public function find(int $id): CourseEntity
    {
        return Course::findOrFail($id)->toCourseEntity();
    }

    public function create(CourseDataTransferObject $course): int
    {
        return Course::create([
            'title' => $course->getTitle(),
            'description' => $course->getDescription(),
            'status' => $course->getStatus()->value,
            'is_premium' => $course->isPremium(),
        ])->id;
    }

    public function update(CourseEntity $course): bool
    {
        $eloquentCourse = Course::findOrFail($course->getId());

        return $eloquentCourse->update([
            'title' => $course->getTitle(),
            'description' => $course->getDescription(),
            'status' => $course->getStatus()->value,
            'is_premium' => $course->isPremium(),
        ]);
    }

    public function delete(int $courseId): bool
    {
        return Course::findOrFail($courseId)->delete();
    }
}
