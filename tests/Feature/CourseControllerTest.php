<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Painting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function course_show_returns_json_on_ajax_request(): void
    {
        $course = factory(Course::class)->create();

        $response = $this->json('get', route('courses.show', compact('course')), [], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertOk();
        $response->assertJson($course->toArray());
    }

    /** @test */
    public function course_show_returns_view_on_normal_request(): void
    {
        $this->withoutExceptionHandling();

        $course = factory(Course::class)->create();

        $response = $this->get(route('courses.show', compact('course')));

        $response->assertOk();
        $response->assertViewIs('courses.show.base');
    }

    /** @test */
    public function show_artists_detail_in_json_is_available(): void
    {
        $course = factory(Course::class)->create();

        factory(Painting::class, 3)->create([
            'course_id' => $course->id,
        ]);

        $response = $this->json('get', route('courses.show', compact('course')), [
            'detail' => 'authors',
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertOk();

        $response->assertJson($course->load('authors')->toArray());
    }

    /** @test */
    public function show_paintings_detail_in_json_is_available(): void
    {
        $course = factory(Course::class)->create();

        factory(Painting::class, 3)->create([
            'course_id' => $course->id,
        ]);

        $response = $this->json('get', route('courses.show', compact('course')), [
            'detail' => 'paintings',
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertOk();

        $response->assertJson($course->load('paintings')->toArray());
    }

    /** @test */
    public function show_paintings_detail_view(): void
    {
        $course = factory(Course::class)->create();

        factory(Painting::class, 3)->create([
            'course_id' => $course->id,
        ]);

        $response = $this->json('get', route('courses.show', compact('course')), [
            'detail' => 'paintings',
        ]);

        $response->assertOk();

        $response->assertViewIs('courses.show.paintings');
    }

    /** @test */
    public function show_artists_detail_view(): void
    {
        $this->withoutExceptionHandling();

        $course = factory(Course::class)->create();

        factory(Painting::class, 3)->create([
            'course_id' => $course->id,
        ]);

        $response = $this->json('get', route('courses.show', compact('course')), [
            'detail' => 'authors',
        ]);

        $response->assertOk();

        $response->assertViewIs('courses.show.authors');
    }
}
