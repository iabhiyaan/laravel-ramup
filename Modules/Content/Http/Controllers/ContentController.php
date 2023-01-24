<?php

namespace Modules\Content\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Content\Entities\Content;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $details = Content::all();
        return view('content::list', compact('details'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'type' => ['string', 'in:video,note,attachment'],
            'content_media' => ['file', 'mimes:jpg,bmp,png,pdf,mp4,mkv'],
        ]);

        $formData = $request->except(['_token']);
        $content = Content::create($formData);

        if ($request->hasFile('content_media')) {
            $file = $request->file('content_media');
            $content
                ->addMedia($file)
                ->toMediaCollection('CONTENT');
        }

        return redirect()->route('content.index')->with('message', 'Content created successfully');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('content::create');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('content::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Content $content)
    {
        $mediaUrl = $content->getFirstMediaUrl('CONTENT');

        return view('content::edit', compact('content', 'mediaUrl'));
    }

    public function update(Request $request, Content $content)
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'type' => ['string', 'in:video,note,attachment'],
            'content_media' => ['file', 'mimes:jpg,bmp,png,pdf,mp4,mkv'],
        ]);

        $formData = $request->except(['_token']);
        $content->update($formData);

        if ($request->hasFile('content_media')) {
            $file = $request->file('content_media');
            $media = $content->getFirstMedia();
            if ($media) {
                $media->delete();
            }

            $content
                ->addMedia($file)
                ->toMediaCollection('CONTENT');
        }

        return redirect()->route('content.index')->with('message', 'Content updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Content $content)
    {
        $content->delete();
        return redirect()->back()->with('message', 'Content deleted successfully');
    }
}
