<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;

class AdminActivityController extends Controller
{
    public function index()
    {
        $activities = AdminActivity::with(['user', 'subject'])
            ->latest()
            ->paginate(20);

        return view('admin.activity.index', compact('activities'));
    }
}
