<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Request;
use Modules\Course\Services\CourseService;

class CourseController extends Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CourseResource::collection($this->courseService->getAllCourses());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
