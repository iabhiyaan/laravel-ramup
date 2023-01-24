<?php

namespace Modules\Folder\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Content\Entities\Content;
use Modules\Folder\Entities\Folder;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $details = Folder::with(['folder'])->get();

        return view('folder::list', compact('details'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'parent_id' => ['nullable', 'exists:folders,id']
        ]);

        $formData = $request->except('_token');
        Folder::create($formData);

        return redirect()->route('folder.index')->with('message', 'Folder Created Successfully');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data = Folder::all();
        return view('folder::create', compact('data'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Folder $folder)
    {
        $folder->load(['folders', 'contents.media' => function ($q) {
            $q->where('collection_name', 'CONTENT');
        }]);
        $depth = $folder->depthHelper($folder->id);

        $contents = Content::all();

        return view('folder::show', compact('folder', 'depth', 'contents'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Folder $folder)
    {
        $data = Folder::all();
        return view('folder::edit', compact('folder', 'data'));
    }

    public function update(Request $request, Folder $folder)
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'parent_id' => ['nullable', 'exists:folders,id']
        ]);

        $formData = $request->except('_token');
        $folder->update($formData);

        return redirect()->route('folder.index')->with('message', 'Folder updated successfully');
    }

    public function destroy(Folder $folder)
    {
        $folder->delete();

        return redirect()->back()->with('message', 'Folder deleted successfully');
    }

    public function syncContentToFolder(Request $request)
    {
        $request->validate([
            'content_ids' => ['required', 'array',],
            'content_ids.*' => ['numeric', 'exists:contents,id'],
            'folder_id' => ['required', 'numeric', 'exists:folders,id'],
        ], [
            'content_ids.*.exists' => 'Please enter valid content',
        ]);

        $content_ids = $request->get('content_ids');
        $folder_id = $request->get('folder_id');

//        $formData = [];
//        foreach ($content_ids as $content_id) {
//            $formData[] = ['content_id' => $content_id, 'folder_id' => $folder_id,];
//        }

        $folder = Folder::find($folder_id);
        if (isset($folder)) {
            $folder->contents()->sync($content_ids);
        }

        return redirect()->back()->with('message', 'Content synced to folders');
    }
}
