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

/**
 * @OA\Info(title="Courses CRUD API", version="1.0")
 */
class CourseController extends Controller
{
    public function __construct(
        private readonly ICourseService $courseService,
    ) {
    }

    /**
     * @OA\Get(
     *      path="/api/v1/courses",
     *      operationId="index",
     *      tags={"Courses"},
     *      summary="Get list of courses",
     *      description="Returns list of courses",
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       )
     *     )
     *
     * Returns list of Courses
     */
    public function index(CourseIndexRequest $request): AnonymousResourceCollection
    {
        $perPage = $request->get('per_page') ?? 10;

        return CourseResource::collection($this->courseService->getAllCoursesPaginated($perPage));
    }

    /**
     * @OA\Post(
     *      path="/api/v1/courses",
     *      operationId="store",
     *      tags={"Courses"},
     *      summary="Store a new course",
     *      description="Accepts a list of items and stores a course",
     *
     *     @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *              required={"title", "description"},
     *
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="description", type="string"),
     *              @OA\Property(property="is_premium", type="boolean"),
     *              @OA\Property(property="status", type="string", enum={"pending", "published"})
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Course created successfully",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="course_id", type="int", example=123)
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={"title": {"The title field is required."}})
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=500,
     *          description="Server error",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="message", type="string", example="Server error occurred."),
     *          )
     *      ),
     * )
     *
     * Stores a new course
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
     * @OA\Get(
     *      path="/api/v1/courses/{course_id}",
     *      operationId="show",
     *      tags={"Courses"},
     *      summary="Searches and shows a single course",
     *      description="Searches and shows a single course",
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Response(
     *          response=422,
     *          description="The course id is not numeric"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Course not found."
     *       ),
     *     )
     *
     * Stores a new course
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
     * @OA\Patch(
     *      path="/api/v1/courses/{course_id}",
     *      operationId="updateCourse",
     *      tags={"Courses"},
     *      summary="Update a course",
     *      description="Updates the specified course with the provided data.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Course ID",
     *
     *          @OA\Schema(type="integer")
     *      ),
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *              required={},
     *
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="description", type="string"),
     *              @OA\Property(property="is_premium", type="boolean"),
     *              @OA\Property(property="status", type="string", enum={"pending", "published"})
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Course updated successfully",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="message", type="string", example="Course updated successfully."),
     *              @OA\Property(property="course_id", type="string", example=123)
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={"title": {"The title field is required."}})
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Course not found",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="message", type="string", example="Course not found."),
     *          )
     *      ),
     * )
     */
    public function update(CourseUpdateRequest $request, string $id): JsonResponse
    {
        try {

            $course = new Course(
                id: intval($id),
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
     * @OA\Delete(
     *      path="/api/v1/courses/{course_id}",
     *      operationId="deleteCourse",
     *      tags={"Courses"},
     *      summary="Delete a course",
     *      description="Deletes the specified course.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Course ID",
     *
     *          @OA\Schema(type="integer")
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Course deleted successfully",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="success", type="boolean", example="true")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Course not found",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="message", type="string", example="Course not found.")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="errors", type="object", example={"status": {"Course id field must be numeric"}})
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=500,
     *          description="Server error",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="message", type="string", example="Server error occurred.")
     *          )
     *      ),
     *      security={ {"bearer": {} } }
     * )
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
