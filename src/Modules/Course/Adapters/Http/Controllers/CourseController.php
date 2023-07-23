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
        return CourseResource::collection($this->courseService->getAllCoursesPaginated());
    }

    /**
     * Store a newly created resource in storage.
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
                'course_id' => $newCourseId
            ]);

        } catch (InvalidCourseStatus $invalidCourseStatus) {
            return response()->json(['errors' => [
                'status' => $invalidCourseStatus->getMessage()
            ]], 422);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
