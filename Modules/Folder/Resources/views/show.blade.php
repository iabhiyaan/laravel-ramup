<x-admin-layout>
    <x-slot name="scripts">
        <script>
            const origin = window.location.origin;
            const path = window.location.pathname;
            if ({{$depth}} > 0) {
                window.history.replaceState(
                    null,
                    '',
                    origin + path + '?depth=' + {{ $depth }}
                );
            }

            var myModal = new bootstrap.Modal(document.getElementById('kt_modal_1'));

            $("#multiple-select-vendor").select2().val({!! json_encode($folder->contents->pluck('id')) !!}).trigger('change');


        </script>
    </x-slot>

    <x-error-message/>

    <div class="card m-3 fade-in-up">
        <div class="card-body">
            <div class="ibox-head">
                <div class="d-flex justify-content-between">
                    <h3>{{ $folder->name }}</h3>
                    <div class="text-right">
                        <a class="btn btn-info btn-md me-3" href="{{ route('folder.create') }}">Add Folder</a>

                        @if($depth > 0)
                            <button data-bs-toggle="modal" data-bs-target="#kt_modal_1"
                                    class="btn btn-outline btn-outline-dashed btn-outline-success btn-active-light-success">
                                Add Contents
                            </button>
                        @endif
                    </div>

                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-striped gy-7 gs-7">
                    <thead>
                    <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                        {{--                        <th>SN</th>--}}
                        <th>Name</th>
                        <th>Date Modified</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($folder->folders as $key => $data)
                        <tr>
                            {{--                            <td>{{ ++$key }}</td>--}}
                            <td>
                                <a href="{{ route('folder.show', $data->id) }}" target="_blank" class="hover-underline">
                                    {{ $data->name }}
                                </a>
                            </td>
                            <td>
                                {{--                                {{ $data->folder->name ?? 'N/A' }}--}}

                                {{ \Carbon\Carbon::parse($data->updated_at)->format('Y-m-d')  }}
                            </td>

                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('folder.edit', $data->id) }}"
                                       class="btn me-2 btn-icon btn-success">Edit</a>
                                    <form action="{{ route('folder.destroy', $data->id) }}"
                                          method="post">
                                        @csrf
                                        @method('delete')
                                        <button style="padding-right: 30px; padding-left: 30px;"
                                                class="btn btn-danger btn-icon" type="submit" name="button"
                                                onclick="return confirm('Are you sure you want to delete this folder?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                You do not have any data yet.
                            </td>
                        </tr>
                    @endforelse
                    @forelse($folder->contents as $content)
                        <tr>
                            <td>

                                <h3>{{ $content->name }}</h3>
                                @if($content->media->isNotEmpty())
                                    @if($content->media[0]->getUrl() !== null && $content->type === 'video')
                                        <video style="max-width: 150px;"
                                               src="{{ $content->media[0]->getUrl() }}"></video>
                                    @endif
                                @endif
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($content->updated_at)->format('Y-m-d')  }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                You do not have any data yet.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{--modals--}}

    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Contents</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="{{ route('folder.sync-content-to-folder') }}" method="POST">
                    @csrf
                    <input type="hidden" name="folder_id" value="{{ $folder->id }}"/>
                    <div class="modal-body">

                        <div class="mb-10">
                            <label for="" class="form-label">Select Contents</label>
                            <select id="multiple-select-vendor" name="content_ids[]" multiple class="form-select form-select-solid"
                                    data-control="select2"
                                    data-dropdown-parent="#kt_modal_1" data-placeholder="Select an option"
                                    data-allow-clear="true">
                                <option></option>
                                @forelse($contents as $content)
                                    <option value="{{ $content->id }}">{{ $content->name }}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button onclick="return confirm('Are you sure you want to add these contents to this folder?')"
                                type="submit" class="btn btn-primary">Save Contents
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <x-slot name="styles">
        <style media="screen">
            .text-right {
                text-align: right;
            }

            a.hover-underline:hover {
                text-decoration: underline !important;
            }

        </style>
    </x-slot>

</x-admin-layout>
