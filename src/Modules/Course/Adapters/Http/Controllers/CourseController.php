<?php

namespace Modules\Course\Adapters\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Course\Adapters\Http\Requests\CourseIndexRequest;
use Modules\Course\Adapters\Http\Resources\CourseResource;
use Modules\Course\Core\DataTransferObjects\CourseDataTransferObject;
use Modules\Course\Core\Enums\CourseStatusEnum;
use Modules\Course\Core\Exceptions\InvalidCourseStatus;
use Modules\Course\Core\Services\Contracts\ICourseService;

class CourseController extends Controller
{
    // TODO Implement this controller, make validations, handle exceptions and write tests
    public function __construct(
        private readonly ICourseService $courseService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CourseIndexRequest $request)
    {
        $perPage = $request->get('per_page') ?? 10;

        return CourseResource::collection($this->courseService->getAllCoursesPaginated($perPage));
    }

    /**
     * Store a newly created resource in storage.
     * TODO Add validation
     */
    public function store(Request $request)
    {
        try {
            $courseDTO = CourseDataTransferObject::build()
                ->setTitle($request->get('title'))
                ->setDescription($request->get('description'))
                ->setStatus(CourseStatusEnum::fromOrThrow($request->get('status')))
                ->setIsPremium($request->get('is_premium'));

            $newCourseId = $this->courseService->createCourse($courseDTO);

            return response()->json([
                'success' => true,
                'course_id' => $newCourseId,
            ]);

        } catch (InvalidCourseStatus $invalidCourseStatus) {
            return response()->json(['errors' => [
                'status' => $invalidCourseStatus->getMessage(),
            ]], 422);
        }

    }

    /**
     * Display the specified resource.
     * TODO Add validation
     */
    public function show(string $id)
    {
        return CourseResource::make($this->courseService->findCourse($id));
    }

    /**
     * Update the specified resource in storage.
     * TODO implement and add validation
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * TODO implement and add validation
     */
    public function destroy(string $id)
    {
        //
    }
}
