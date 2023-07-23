<?php

namespace Modules\Course\Core\Enums;

use Modules\Course\Core\Exceptions\InvalidCourseStatus;

enum CourseStatusEnum: string
{
    case PENDING = 'pending';
    case PUBLISHED = 'published';

    /**
     * @throws InvalidCourseStatus
     */
    public static function fromOrThrow(
        string $value): self
    {
        $status = self::tryFrom($value);

        if (! $status) {
            throw new InvalidCourseStatus('Invalid course status.');
        }

        return $status;
    }
}
