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
        $course = Course::with(['lessons', 'mediaGallery'])->where('slug', $slug)->firstOrFail();

        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = Enrollment::where('course_id', $course->id)->where('user_id', auth()->id())->exists();
        }

        return view('courses.show', compact('course', 'isEnrolled'));
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
        $enrollments = Enrollment::with('course.lessons')->where('user_id', auth()->id())->latest()->paginate(10);

        return view('dashboard.user.courses', compact('enrollments'));
    }
}
