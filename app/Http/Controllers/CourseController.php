<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
    public function show(Course $course, Request $request): Response
    {
        $ajax = $request->headers->get('X-Requested-With') === 'XMLHttpRequest';

        if ($ajax) {
            if ($request->get('detail') === 'paintings') {
                $course->load('paintings');
            } elseif ($request->get('detail') === 'authors') {
                $course->load('authors');
            }

            return response()->json($course);
        } else {
            if ($request->get('detail') === 'paintings') {
                return response()->view('courses.show.paintings', compact('course'));
            } elseif ($request->get('detail') === 'authors') {
                return response()->view('courses.show.authors', compact('course'));
            }

            return response()->view('courses.show.base', compact('course'));
        }
    }
}
