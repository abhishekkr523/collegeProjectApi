<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class HodController extends Controller
{
   public function index(){
        $role = Role::where('name', 'HOD')->first();
        dd($role);
   } 
}
