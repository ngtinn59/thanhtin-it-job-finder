<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployerController extends Controller
{

    public function __call($method, $parameters)
    {
        parent::__call($method, $parameters);
    }
}
