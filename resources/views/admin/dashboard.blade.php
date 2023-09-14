@extends('admin.template')
@section('view')
<div class="row">
    <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">directions_car</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Mobil Tersedia</p>
                    <h4 class="mb-0">{{ $remaining_car }} Unit</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-sm-6">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">weekend</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Total Riwayat Sewa Mobil</p>
                    <h4 class="mb-0">{{ $total_rent }} Unit</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mt-4"></div>
@endsection
@section('script')
@endsection