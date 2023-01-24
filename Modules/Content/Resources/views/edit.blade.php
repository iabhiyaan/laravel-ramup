<x-admin-layout title="Edit Folder">
    <x-error-message/>
    <form method="post" action="{{ route('content.update', $content->id) }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="py-5">
            <div class="rounded border p-10">

                <div class="mb-10">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $content->name }}"/>
                </div>

                <div class="mb-10">
                    <label class="form-label">Select Parent</label>
                    <select name="type" class="form-control" value="{{ $content->type }}">
                        <option {{ ($content->type === 'video') ? 'selected' : ''  }} value="video">Video</option>
                        <option {{ ($content->type === 'note') ? 'selected' : ''  }} value="note">Note</option>
                        <option {{ ($content->type === 'attachment') ? 'selected' : ''  }} value="attachment">
                            Attachment
                        </option>
                    </select>
                </div>

                <div class="mb-10">
                    <label class="form-label">Select File</label>
                    <input type="file" name="content_media" value="{{ $content->content_media }}" class="form-control"/>
                    @if(isset($mediaUrl) && $content->type === 'video')
                        <video style="max-width: 200px" src="{{ $mediaUrl }}" />
                    @endif
                </div>

                <button type="submit" class="btn btn-primary fw-bolder fs-6 px-8 py-4 my-3 me-3">Save</button>
            </div>
        </div>
    </form>

    <x-slot name="styles">
        <style></style>
    </x-slot>
</x-admin-layout>
