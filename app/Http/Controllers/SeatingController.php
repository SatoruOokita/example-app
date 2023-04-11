<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeatingController extends Controller
{
    public function index()
    {
        return view('sekigae.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'students' => 'required|integer|min:1',
            'rows' => 'required|integer|min:1',
            'columns' => 'required|integer|min:1',
        ]);

        $students = range(1, $request->students);
        shuffle($students);

        $seats = array_chunk($students, $request->columns);

        return view('sekigae.show', [
            'students' => $request->students,
            'rows' => $request->rows,
            'columns' => $request->columns,
            'seats' => $seats,
        ]);
    }

    public function show()
    {
        return view('sekigae.show');
    }
}