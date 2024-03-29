<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Course;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'time' => 'required',
            'start_date' => 'required|after:today',
            'end_date' => 'required|after:today',
        ]);

        $course = new Course();
        $course->name = $request->input('name');
        $course->description = $request->input('description');
        $course->time = $request->input('time');
        $course->start_date = $request->input('start_date');
        $course->end_date = $request->input('end_date');

        $course->save();

        return back()->with('success', 'Course created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        $materials = $course->materials;
        $tutors = $course->users;
        session(['course_id' => $course->id]);
        $context = [
            'course'=> $course,
            'materials' => $materials,
            'tutors' => $tutors
        ];

        return view('show', $context);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::find($id);
        return view('courses.edit', ['course'=>$course]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'time' => 'required',
            'start_date' => 'required|after:today',
            'end_date' => 'required|after:today',
        ]);

        $course = Course::find($id);
        $course->name = $request->input('name');
        $course->description = $request->input('description');
        $course->time = $request->input('time');
        $course->start_date = $request->input('start_date');
        $course->end_date = $request->input('end_date');

        $course->save();

        return back()->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();

        return view('home')->with('success', 'course deleted successfully');
    }
}
