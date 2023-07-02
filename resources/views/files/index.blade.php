@extends('templates.base')

@props(['files'])

@section('content')
    <form method="post" action="{{ route('files.store') }}">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>File Name</th>
                    <th>DateTime</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $index => $file)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $file }}</td>
                        <td>{{ \Carbon\Carbon::createFromFormat('ymdHis', substr($file, 0, 12))->format('Y-m-d H:i:s') }}
                        </td>
                        <td><input type="checkbox" name="selectedFiles[]" value="{{ $file }}"></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input type="checkbox" id="selectAll"></td>
                </tr>
            </tfoot>
        </table>
        <button type="submit" class="btn btn-primary">Display</button>
    </form>

    <script>
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('input[name="selectedFiles[]"]');

        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    </script>
@endsection
