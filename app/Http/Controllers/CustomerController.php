<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Root\Routing\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        return [
            'Dentro de Customer Controller',
        ];
    }
}