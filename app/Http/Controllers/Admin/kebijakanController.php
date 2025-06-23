<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\kebijakan;
use App\Models\Language;
use Illuminate\Http\Request;

class kebijakanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:kebijakan index,admin'])->only(['index']);
        $this->middleware(['permission:kebijakan update,admin'])->only(['update']);
    }

    public function index()
    {
        $languages = Language::all();

        return view('admin.kebijakan-page.index', compact('languages'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => ['required']
        ]);

        kebijakan::updateOrCreate(
            ['language' => $request->language],
            [
                'content' => $request->content
            ]
        );

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }
}
