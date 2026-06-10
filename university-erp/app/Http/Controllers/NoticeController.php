<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $notices = Notice::with('user')

            ->when($request->search, function ($query) use ($request) {

                $query->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('category', 'like', '%' . $request->search . '%');

            })

            ->latest()
            ->paginate(10);

        return view('notices.index', compact('notices'));
    }

    public function create()
    {
        return view('notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required',
            'content'      => 'required',
            'category'     => 'required',
            'audience'     => 'required',
            'publish_date' => 'required|date',
        ]);

        Notice::create([
            'user_id'      => Auth::id(),
            'title'        => $request->title,
            'content'      => $request->content,
            'category'     => $request->category,
            'audience'     => $request->audience,
            'is_published' => $request->has('is_published'),
            'publish_date' => $request->publish_date,
            'expire_date'  => $request->expire_date,
        ]);

        return redirect()
            ->route('notices.index')
            ->with('success', 'Notice Added Successfully');
    }

    public function show(Notice $notice)
    {
        return view('notices.show', compact('notice'));
    }

    public function edit(Notice $notice)
    {
        return view('notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'title'        => 'required',
            'content'      => 'required',
            'category'     => 'required',
            'audience'     => 'required',
            'publish_date' => 'required|date',
        ]);

        $notice->update([
            'title'        => $request->title,
            'content'      => $request->content,
            'category'     => $request->category,
            'audience'     => $request->audience,
            'is_published' => $request->has('is_published'),
            'publish_date' => $request->publish_date,
            'expire_date'  => $request->expire_date,
        ]);

        return redirect()
            ->route('notices.index')
            ->with('success', 'Notice Updated Successfully');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();

        return redirect()
            ->route('notices.index')
            ->with('success', 'Notice Deleted Successfully');
    }
}