@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Lisensi</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

    </div>
</div>
{{-- End Header --}}



<div class="card flex-fill">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h4> <span class="ti ti-key"></span> Lisensi</h4>
        <div class="d-flex align-items-center">
            <div id="instansi"></div>
            @foreach ($lisensi as $item)
             {{ $item->instansi }}

            @endforeach

        </div>
    </div>
    <div class="card-body p-0 m-0">
        <div class="bg-light-300 rounded-2 p-5 ">

            <div align="center">
                @if($lisensi->count() == 0)
                    <a href="{{ route('lisensiIndexGet') }}" class="btn btn-primary "><span class="ti ti-key"></span> Generate Key</a >
                @endif
                @foreach ($lisensi as $item)
                    <h4>{{ $item->lisensi }}</h4>
                    <div class="mt-2">
                        @if($item->status == 'Active')
                        <span class="badge badge-soft-success d-inline-flex align-items-center">Active</span>
                            @if($item->subscription_type == 'Lifetime')
                            <span class="badge badge-soft-info d-inline-flex align-items-center">Subcription : {{ $item->subscription_type }}</span>
                            @elseif($item->subscription_type == 'Yearly')
                            <span class="badge badge-soft-info d-inline-flex align-items-center">Subcription : {{ $item->subscription_type }}</span>
                            <span class="badge badge-soft-warning d-inline-flex align-items-center">Expired : {{ $item->expired }}</span>
                            @elseif($item->subscription_type == 'Monthly')
                            <span class="badge badge-soft-info d-inline-flex align-items-center">Subcription : {{ $item->subscription_type }}</span>
                            <span class="badge badge-soft-warning d-inline-flex align-items-center">Expired : {{ $item->expired }}</span>
                            @endif
                        @elseif($item->status == 'Pending')
                        <span class="badge badge-soft-warning d-inline-flex align-items-center">Pending</span>
                        @elseif($item->status == 'Expired')
                        <span class="badge badge-soft-danger d-inline-flex align-items-center">Expired : {{ $item->expired }}</span>
                        @endif
                    </div>
                @endforeach

            </div>

        </div>
    </div>

</div>


@section('javascript')
{{-- <script>
    function refreshdata(){

    var content="";
    var instansi="";
    $.ajax({
        url:"{{ route('lisensiIndexGet') }}",
        method:"GET",
        dataType:"json",
        success: function(data){
            for(i=0;i<data.length;i++){
                    content +=''+
                        data[i].lisensi
                    instansi +=''+
                        data[i].instansi +'<span class="ti ti-key"></span>'
                }
            $('#lisensi').html(content);
            $('#instansi').html(instansi);
        }
    });
}
    setInterval(refreshdata,2000); --}}
</script>
@endsection
@endsection
