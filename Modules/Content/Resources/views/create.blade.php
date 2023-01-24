<x-admin-layout title="Create Content">
    <x-error-message />
    <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="py-5">
            <div class="rounded border p-10">

                <div class="mb-10">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"/>
                </div>

                <div class="mb-10">
                    <label class="form-label">Select Type</label>
                    <select name="type" class="form-control" value="{{ old('type') }}">
                        <option value="video">Video</option>
                        <option value="note">Note</option>
                        <option value="attachment">Attachment</option>
                    </select>
                </div>

                <div class="mb-10">
                    <label class="form-label">Select File</label>
                    <input type="file" name="content_media" value="{{ old('content_media') }}" class="form-control" />
                </div>

                <button type="submit" class="btn btn-primary fw-bolder fs-6 px-8 py-4 my-3 me-3">Save</button>
            </div>
        </div>
    </form>

    <x-slot name="styles">
        <style></style>
    </x-slot>

</x-admin-layout>
