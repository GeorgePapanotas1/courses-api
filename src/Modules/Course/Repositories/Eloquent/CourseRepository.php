<?php

namespace Modules\Course\Repositories\Eloquent;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Course\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Models\Course;
use Modules\Course\Repositories\Contracts\ICourseRepository;

class CourseRepository implements ICourseRepository
{
    private function mapToDTO(Course $course): CourseDataTransferObject
    {
        return CourseDataTransferObject::build()
            ->setId($course->id)
            ->setTitle($course->title)
            ->setDescription($course->description)
            ->setStatus($course->status)
            ->setIsPremium($course->is_premium)
            ->setCreatedAt($course->created_at)
            ->setUpdatedAt($course->updated_at);
    }

    public function all(): array
    {
        return Course::all()->map(fn (Course $course) => $this->mapToDTO($course))->toArray();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        $tasks = Course::paginate($perPage);

        return new LengthAwarePaginator(
            $tasks->map(fn (Course $course) => $this->mapToDTO($course)),
            $tasks->total(),
            $tasks->perPage(),
            $tasks->currentPage()
        );
    }

    public function find(int $id): CourseDataTransferObject
    {
        return $this->mapToDTO(Course::findOrFail($id));
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

    public function update(CourseDataTransferObject $course): bool
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
