<?php

namespace App\Http\Controllers;
use App\Models\ClassGroup;
use Illuminate\Http\Request;

class ClassGroupController extends Controller
{
    public function show(ClassGroup $classGroup)
{
    return view('classes.show', compact('classGroup'));
}
}
