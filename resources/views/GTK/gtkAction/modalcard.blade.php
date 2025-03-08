
<div class="modal fade" id="gtkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <form action="{{ route('cardmulti') }}" method="post" target="_blank">
            @csrf
        <div class="modal-content">
            <div class="modal-header bg-primary" >

                <h5 class="modal-title text-white" id="exampleModalLabel"><i class="ti ti-printer"></i> Cetak Kartu Guru dan Tenaga Kependidikan</h5>
                <div class="bt-group">
                    <button class="btn btn-success floating-btn" id="submit-btn"><i class="ti ti-printer"></i> Cetak </button>
                    <a class="btn btn-success floating-btn" data-bs-dismiss="modal">Batal </a>
                </div>

            </div>
            <div class="modal-body m-0 p-0">
                <!-- DataTable Section -->
                <table id="tabelguru" class="table table-bordered" >
                    <thead>
                        <tr>

                            <th>
                                <div class="form-check form-check-md">
                                    <input type="checkbox" class="form-check-input" id="select-all">

                                </div>

                            </th>
                            <th>NIK / No. KITAS (Untuk WNA)</th>
                            <th>Nama Lengkap</th>
                            <th>Gender</th>

                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </form>
    </div>
</div>
<script>
        $('#submit-btn').on('click', function(event) {
        // Check if at least one checkbox is checked
        if ($('input[name="id[]"]:checked').length === 0) {
          event.preventDefault(); // Prevent form submission
          Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Silakan pilih setidaknya satu data.',
            confirmButtonText: 'OK'
            });
        } else {

        }
      });
    $(".kelas").select2({
        dropdownParent: "#studentModal",
        placeholder: "Cetak seluruh siswa di Kelas",

    });
</script>
