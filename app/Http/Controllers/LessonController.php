<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;

class LessonController extends Controller
{
    public function create(Request $request, Course $course, Module $module)
    {
        return Inertia::render('Admin/Lesson/Create', [
            'course' => $course,
            'module' => $module
        ]);
    }

    public function store(StoreLessonRequest $request, Course $course, Module $module)
    {
        $lesson = Lesson::create(array_merge(
            $request->all(),
            [
                'module_id' => $module->id,
            ]
        ));

        $module->lessons()->save($lesson);

        return Redirect::route('course.module.edit', [
            'course' => $course,
            'module' => $module
        ]);
    }

    public function edit(Request $request, Course $course, Module $module, Lesson $lesson)
    {
        return Inertia::render('Admin/Lesson/Edit', [
            'module' => $module,
            'course' => $course,
            'lesson' => $lesson
        ]);
    }

    public function update(UpdateLessonRequest $request, Course $course, Module $module, Lesson $lesson)
    {
        $lesson->update($request->all());

        return Redirect::route('course.module.edit', [
            'course' => $course,
            'module' => $module
        ]);
    }

    // public function destroy(Request $request, Course $course, Module $module)
    // {
    //     $module->delete();

    //     return Redirect::route('course.edit', $course);
    // }
}
