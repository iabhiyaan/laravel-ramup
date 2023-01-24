<x-admin-layout title="All Contents">
    <div class="card m-3 fade-in-up">
        <div class="card-body">
            <div class="ibox-head">
                <div class="text-right">
                    <a class="btn btn-info btn-md" href="{{ route('content.create') }}">Add Content</a>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-striped gy-7 gs-7">
                    <thead>
                    <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>SN</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($details as $key => $data)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $data->name }}</td>
                            <td>
                                {{ $data->type ?? 'N/A' }}
                            </td>

                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('content.edit', $data->id) }}"
                                       class="btn me-2 btn-icon btn-success">Edit</a>
                                    <form action="{{ route('content.destroy', $data->id) }}"
                                          method="post">
                                        @csrf
                                        @method('delete')
                                        <button style="padding-left: 30px; padding-right: 30px;" class="btn btn-danger btn-icon" type="submit" name="button"
                                                onclick="return confirm('Are you sure you want to delete this content?')">
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
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <x-slot name="styles">
        <link href="{{ asset('/assets/admin/vendors/DataTables/datatables.min.css') }}" rel="stylesheet"/>

        <style media="screen">
            .text-right {
                text-align: right;
            }

        </style>
    </x-slot>

</x-admin-layout>
