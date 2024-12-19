@extends('layout.main')
@section('css')
<style>
    #loadingSpinner {
    margin-top: 20px;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}
</style>
@endsection
@section('container')
    <h1>Preview Excel Data</h1>
    <div class="mt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    @if (!empty($previewData[0]))
                        @foreach ($previewData[0] as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($previewData as $key => $row)
                    @if ($key > 0) <!-- Skip header row -->
                        <tr>
                            @foreach ($row as $cell)
                                <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <form action="{{ route('save.preview.data') }}" method="POST">
        @csrf
        <input type="hidden" name="excel_data" value="{{ json_encode($previewData) }}">
        <div class="d-flex justify-content-end mt-3">
            <input type="text" name="id_kelas" value="{{ $id_kelas }}" hidden>
            <input type="text" name="task_id" value="{{ $task_id }}" hidden>
            <a class="btn btn-success me-2" href="{{ url()->previous() }}">Go Back</a>
            <button type="submit" class="btn btn-primary">Import Data</button>
        </div>
    </form>
     <!-- Loading Animation -->
     <div id="loadingSpinner" class="d-none text-center mt-3">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Uploading data, please wait...</p>
    </div>

    @section('javascript')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const importForm = document.getElementById("importForm");
        const importButton = document.getElementById("importButton");
        const loadingSpinner = document.getElementById("loadingSpinner");

        importForm.addEventListener("submit", function (e) {
            // Tampilkan loading spinner
            loadingSpinner.classList.remove("d-none");
            // Nonaktifkan tombol untuk mencegah klik ganda
            importButton.disabled = true;
            importButton.textContent = "Importing...";
        });
    });

    </script>
@endsection
@endsection
