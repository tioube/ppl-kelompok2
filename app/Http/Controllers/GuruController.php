<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = User::whereHas('roles', function($query) {
            $query->where('name', 'guru');
        })->with('roles')->paginate(10);

        return view('pages.guru.index', [
            'title' => 'List Guru',
            'gurus' => $gurus
        ]);
    }
}
