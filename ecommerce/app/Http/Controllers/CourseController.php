<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseEnrollmentRequest;
use App\Models\Course;
use App\Models\Enrollment;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_published', true)->latest()->paginate(9);
        return view('courses.index', compact('courses'));
    }

    public function show($slug)
    {
        $course = Course::with('lessons')->where('slug', $slug)->firstOrFail();
        return view('courses.show', compact('course'));
    }

    public function enroll(StoreCourseEnrollmentRequest $request)
    {
        Enrollment::firstOrCreate(
            ['user_id' => $request->user()->id, 'course_id' => $request->course_id],
            ['status' => 'active', 'enrolled_at' => now()]
        );

        return back()->with('success', __('messages.course_enrolled'));
    }

    public function myCourses()
    {
        $enrollments = Enrollment::with('course')->where('user_id', auth()->id())->latest()->paginate(10);
        return view('dashboard.user.courses', compact('enrollments'));
    }
}
