@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">Daftar {{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item " aria-current="page">Pengguna</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="pe-1 mb-2">
            <a href="#" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh">
                <i class="ti ti-refresh"></i>
            </a>
        </div>


    </div>
</div>
<form action="{{ route('usermodulesPermissionChange') }}" method="post">
    @csrf
    <input type="text" name="role" value="{{ $id }}">
    <div class="table-responsive">
        <div class="card">
            <div class="card-header">
                <h4>Permission Access User</h4>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="1%">Select</th>
                        <th>Akses Menu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modules as $item)
                    <tr>
                        <td class="border">
                            <div class="form-check form-check-md d-flex justify-content-center">
                                <input class="form-check-input" name="permission[{{ $item->id }}][name]" value="{{ $item->name }}" type="checkbox"
                                {{ $cekmodul->count() && $cekmodul->where('permission_id', $item->id)->first() ? 'checked' : '' }}>

                            </div>
                        </td>
                        <td>{{ $item->name }}</td>

                    </tr>
                    @endforeach
                    <tr>
                        <td class="border">
                            <div class="form-check form-check-md">
                                <input class="form-check-input" name="select-all"  type="checkbox" id="select-all"

                                >
                            </div>
                        </td>
                        <td scope="5">
                            <span class="ti ti-arrow-left"></span> <b>Allow All</b>
                            <button type="submit" class="action-btn save-btn btn btn-primary btn-sm mx-3">Simpan Perubahan</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>



{{-- <table class="table table-nowrap my-0">
    <thead>
        <tr>
            <th>
                <div class="form-check form-check-md">
                    <input class="form-check-input mydata" type="checkbox" id="select-all">
                </div>
            </th>
            <th class="bg-light-400" width="20%">Modules</th>
            <th class="bg-light-400 text-center">Created</th>
            <th class="bg-light-400 text-center">View</th>
            <th class="bg-light-400 text-center">Edit</th>
            <th class="bg-light-400 text-center">Delete</th>

        </tr>
    </thead>
    <tbody>
        <form action="{{ route('usermodulesPermissionChange') }}" method="post">
            @csrf
            @foreach ($modules as $index => $item)
            <tr>
                <td class="border" style="align-items: center;">
                    <label class="checkboxs" for="checkbox_{{ $index }}_1">
                        <input type="checkbox" id="checkbox_{{ $index }}_1" value="{{ $item->name }}" name="name[]"
                            class="form-check-input">
                        <span class="checkmarks"></span>
                    </label>
                </td>
                <td>
                    {{ $item->name }}
                </td>
                <td class="border" style="center; align-items: center;">
                    <label class="checkboxs" for="checkbox_{{ $index }}_2">
                        <input type="checkbox" id="checkbox_{{ $index }}_2" value="create" name="permisision[]"
                            class="form-check-input">
                        <span class="checkmarks"></span>
                    </label>
                </td>
                <td class="border" style=" align-items: center;">
                    <label class="checkboxs" for="checkbox_{{ $index }}_3">
                        <input type="checkbox" id="checkbox_{{ $index }}_3" value="read" name="permisision[]"
                            class="form-check-input">
                        <span class="checkmarks"></span>
                    </label>
                </td>
                <td class="border " style=" align-items: center;">
                    <label class="checkboxs" for="checkbox_{{ $index }}_4">
                        <input type="checkbox" id="checkbox_{{ $index }}_4" value="update" name="permisision[]"
                            class="form-check-input">
                        <span class="checkmarks"></span>
                    </label>
                </td>
                <td class="border " style=" align-items: center;">
                    <label class="checkboxs" for="checkbox_{{ $index }}_5">
                        <input type="checkbox" id="checkbox_{{ $index }}_5" value="delete" name="permisision[]"
                            class="form-check-input">
                        <span class="checkmarks"></span>
                    </label>
                </td>

            </tr>
            @endforeach
            <button>ads</button>
        </form>
    </tbody>
</table> --}}
</div>

@section('script')
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="permission"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection
@endsection
