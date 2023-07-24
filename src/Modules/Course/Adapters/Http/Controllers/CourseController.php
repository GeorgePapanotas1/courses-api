<?php

namespace Modules\Course\Adapters\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Log;
use Modules\Course\Adapters\Http\Requests\CourseCreationRequest;
use Modules\Course\Adapters\Http\Requests\CourseIndexRequest;
use Modules\Course\Adapters\Http\Requests\CourseUpdateRequest;
use Modules\Course\Adapters\Http\Resources\CourseResource;
use Modules\Course\Core\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Core\Domain\Course;
use Modules\Course\Core\Enums\CourseStatusEnum;
use Modules\Course\Core\Exceptions\CourseNotCreatedException;
use Modules\Course\Core\Exceptions\InvalidCourseStatus;
use Modules\Course\Core\Services\Contracts\ICourseService;

class CourseController extends Controller
{
    public function __construct(
        private readonly ICourseService $courseService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CourseIndexRequest $request): AnonymousResourceCollection
    {
        $perPage = $request->get('per_page') ?? 10;

        return CourseResource::collection($this->courseService->getAllCoursesPaginated($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseCreationRequest $request): JsonResponse
    {
        try {
            $courseDTO = CourseDataTransferObject::build()
                ->setTitle($request->get('title'))
                ->setDescription($request->get('description'))
                ->setStatus(CourseStatusEnum::fromOrThrow($request->get('status') ?? 'pending'))
                ->setIsPremium($request->get('is_premium') ?? false);

            $newCourseId = $this->courseService->createCourse($courseDTO);

            return response()->json([
                'success' => true,
                'course_id' => $newCourseId,
            ]);

        } catch (InvalidCourseStatus $invalidCourseStatus) {
            return response()->json(['errors' => [
                'status' => $invalidCourseStatus->getMessage(),
            ]], 422);
        } catch (CourseNotCreatedException $courseNotCreatedException) {
            Log::error($courseNotCreatedException->getMessage());

            return response()->json(['errors' => [
                'status' => 'Internal error. Course not created.',
            ]], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): CourseResource|JsonResponse
    {
        if (! is_numeric($id)) {
            return response()->json(['errors' => [
                'status' => 'Course id field must be numeric',
            ]], 422);
        }
        try {

            return CourseResource::make($this->courseService->findCourse($id));

        } catch (ModelNotFoundException $notFoundException) {
            return response()->json(['errors' => [
                'status' => 'Course not found.',
            ]], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request, string $id): JsonResponse
    {
        try {

            $course = new Course(
                id: $id,
                title: $request->get('title'),
                description: $request->get('description'),
                status: CourseStatusEnum::fromOrThrow($request->get('status')),
                isPremium: $request->get('is_premium'),
            );

            $updated = $this->courseService->updateCourse($course);

            return response()->json([
                'success' => $updated,
                'course_id' => $course->getId(),
            ]);

        } catch (InvalidCourseStatus $invalidCourseStatus) {
            return response()->json(['errors' => [
                'status' => $invalidCourseStatus->getMessage(),
            ]], 422);
        } catch (ModelNotFoundException $notFoundException) {
            return response()->json(['errors' => [
                'status' => 'Course not found.',
            ]], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        if (! is_numeric($id)) {
            return response()->json(['errors' => [
                'status' => 'Course id field must be numeric',
            ]], 422);
        }

        try {

            $deleted = $this->courseService->deleteCourse($id);

            return response()->json([
                'success' => $deleted,
            ]);

        } catch (ModelNotFoundException $notFoundException) {
            return response()->json(['errors' => [
                'status' => 'Course not found.',
            ]], 404);
        }

    }
}
