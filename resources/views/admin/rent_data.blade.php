@extends('admin.template')
@section('view')
<div class="row">
    <!-- Zero config table start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header" style="display:flex;justify-content: space-between;">
                <h5>{{$page}}</h5>
            </div>
            <div class="card-body">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Penyewa</th>
                                <th>Merk</th>
                                <th>Model</th>
                                <th>Tanggal Mulai Sewa</th>
                                <th>Tanggal Selesai Sewa</th>
                                <th>Harga Per Hari</th>
                                <th>Harga</th>
                                <th>Final Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Zero config table end -->
</div>
<div class="modal fade bs-example-modal-lg modalKonfirmasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Konfirmasi Pengembalian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit" method="POST" class="text-start">
                <div class="modal-body">
                    <input type="hidden" id="return_id" name="id">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" id="return_brand" name="brand">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Model</label>
                        <input type="text" class="form-control" id="return_model" name="model">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Plat Nomor</label>
                        <input type="text" class="form-control" id="return_number_plate" name="number_plate">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Konfirmasi Kembalikan Mobil</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection
@section('script')
<script>
    var table = $('#simpletable').DataTable({
        ajax: "{{url('admin/data/rent-data')}}",
        processing: true,
        serverSide: true,
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'brand',
                name: 'brand'
            },
            {
                data: 'model',
                name: 'model'
            },
            {
                data: 'date_start_rent',
                name: 'date_start_rent'
            },
            {
                data: 'date_end_rent',
                name: 'date_end_rent'
            },
            {
                data: 'car_price',
                name: 'car_price'
            },
            {
                data: 'price',
                name: 'price'
            },
            {
                data: 'price_correction',
                name: 'price_correction'
            },
            {
                data: 'status',
                name: 'status'
            },
        ],
    });
</script>
@endsection