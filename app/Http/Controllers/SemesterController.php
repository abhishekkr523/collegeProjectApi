<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
       $role= Semester::all();
        return response()->json($role);
    }
}
