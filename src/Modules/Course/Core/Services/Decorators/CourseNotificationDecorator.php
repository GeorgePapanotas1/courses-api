<?php

namespace Modules\Course\Core\Services\Decorators;

use Log;
use Modules\Course\Core\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Core\Domain\Course;

/*
 * This is out of scope. Experimenting with decorators.
 */
class CourseNotificationDecorator extends CourseServiceDecorator
{
    public function createCourse(CourseDataTransferObject $course): int
    {
        $value = parent::createCourse($course);
        Log::info('Course created. Notifying admins');

        return $value;
    }

    public function updateCourse(Course $course): bool
    {
        $value = parent::updateCourse($course);
        Log::info('Course updated. Notifying admins');

        return $value;
    }

    public function deleteCourse(int $courseId): bool
    {
        $value = parent::deleteCourse($courseId);
        Log::info('Course deleted. Notifying admins');

        return $value;
    }
}
