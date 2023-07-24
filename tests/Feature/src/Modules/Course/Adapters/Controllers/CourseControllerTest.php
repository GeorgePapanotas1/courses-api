<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Course\Core\Models\Course;

// Adding this here. Normally it should reside in Pest.php
uses(RefreshDatabase::class);

it('can store a new course', function () {

    $data = [
        'title' => 'Test Course',
        'description' => 'This course is a test',
    ];

    $response = $this->post('/api/v1/courses', $data);

    $response->assertStatus(200);
    $this->assertDatabaseHas('courses', $data);
});

it('throws error in invalid status on store', function () {

    $data = [
        'title' => 'Test Course',
        'description' => 'This course is a test',
        'status' => 'rejected'
    ];

    $response = $this->post('/api/v1/courses', $data);

    $response->assertStatus(422);
});

it('can fetch a specific resource', function () {

    $course = Course::create([
        'title' => 'test',
        'description' => 'test descr',
    ]);

    $response = $this->get("/api/v1/courses/$course->id");

    $response->assertStatus(200);
});

it('Throws 404 on specific resource', function () {
    $response = $this->get("/api/v1/courses/9999");

    $response->assertStatus(404);
});

it('It can update a course resource', function () {


    $course = Course::create([
        'title' => 'test',
        'description' => 'test descr',
    ]);

    $data = [
        'title' => 'updated title',
        'description' => 'updated description',
        'status' => 'published',
        'is_premium' => true
    ];

    $response = $this->put("/api/v1/courses/$course->id", $data);

    $response->assertStatus(200);
    $this->assertDatabaseHas('courses', $data);
});

it('Throws 422 on invalid data', function () {


    $course = Course::create([
        'title' => 'test',
        'description' => 'test descr',
    ]);

    $data = [
        'description' => 'updated description',
        'status' => 'rejected',
        'is_premium' => true
    ];

    $response = $this->put("/api/v1/courses/$course->id", $data);

    $response->assertStatus(422);
});

it('can delete a resource', function () {


    $course = Course::create([
        'title' => 'test',
        'description' => 'test descr',
    ]);

    $data = [
        'id' => $course->id,
    ];

    $response = $this->delete("/api/v1/courses/$course->id");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('courses', $data);

});

it('throws 422 on invalid id', function () {


    $response = $this->delete("/api/v1/courses/test");

    $response->assertStatus(422);

});
