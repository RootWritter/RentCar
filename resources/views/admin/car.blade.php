@extends('admin.template')
@section('view')
<div class="row">
    <!-- Zero config table start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header" style="display:flex;justify-content: space-between;">
                <h5>{{$page}}</h5>
                <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal" data-bs-target=".modalAdd"><i class="fas fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="card-body">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Merk</th>
                                <th>Model</th>
                                <th>Plat Nomor</th>
                                <th>Harga</th>
                                <th>Action</th>
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
<div class="modal fade bs-example-modal-lg modalAdd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add" method="POST" class="text-start">
                <div class="modal-body">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" name="brand">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Model</label>
                        <input type="text" class="form-control" name="model">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Plat Nomor</label>
                        <input type="text" class="form-control" name="number_plate">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" name="price">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade bs-example-modal-lg modalEdit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add" method="POST" class="text-start">
                <div class="modal-body">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" id="edit_brand" name="brand">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Model</label>
                        <input type="text" class="form-control" id="edit_model" name="model">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Plat Nomor</label>
                        <input type="text" class="form-control" id="edit_number_plate" name="number_plate">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" id="edit_price" name="price">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Edit Data</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection
@section('script')
<script>
    var table = $('#simpletable').DataTable({
        ajax: "{{url('admin/data/car')}}",
        processing: true,
        serverSide: true,
        columns: [{
                data: 'id',
                name: 'id'
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
                data: 'number_plate',
                name: 'number_plate'
            },
            {
                data: 'price',
                name: 'price'
            },
            {
                data: 'action',
                name: 'action'
            },
        ],
    });
    $("#add").submit(function(e) {
        e.preventDefault();
        var form = new FormData(this);
        form.append('action', 'add');
        form.append('_token', token);
        axios.post("{{url('admin/ajax/car')}}", form)
            .then(response => {
                $(".modalAdd").modal('hide');
                if (response.data.status) {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(function() {
                            $(".modalAdd").modal('hide');
                            table.ajax.reload();
                        });
                    }, 200);
                } else {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                }
            })
            .catch(error => {
                $(".modalAdd").modal('hide')
                if (error.response) {
                    const data = error.response.data;
                    var errorAjax = data.errors;
                    let errorMessage = '';
                    Object.keys(errorAjax).map(function(key) {
                        errorMessage += errorAjax[key][0] + '<br/>'
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: errorMessage,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Server mengalami masalah!',
                    })
                }
            });
    })

    function edit(id) {
        $(".modalEdit").modal('show');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{url('admin/data/get-car')}}",
            data: {
                id: id,
                _token: token
            },
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_brand").val(data.brand);
                $("#edit_model").val(data.model);
                $("#edit_number_plate").val(data.number_plate);
                $("#edit_price").val(data.price).trigger('click');
            }
        })
    }
    $("#edit").submit(function(e) {
        e.preventDefault();
        var form = new FormData(this);
        form.append('action', 'edit');
        form.append('_token', token);
        axios.post("{{url('admin/ajax/car')}}", form)
            .then(response => {
                $(".modalEdit").modal('hide');
                if (response.data.status) {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(function() {
                            $(".modalEdit").modal('hide');
                            table.ajax.reload();
                        });
                    }, 200);
                } else {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                }
            })
            .catch(error => {
                $(".modalEdit").modal('hide')
                if (error.response) {
                    const data = error.response.data;
                    var errorAjax = data.errors;
                    let errorMessage = '';
                    Object.keys(errorAjax).map(function(key) {
                        errorMessage += errorAjax[key][0] + '<br/>'
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: errorMessage,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Server mengalami masalah!',
                    })
                }
            });
    })

    function hapus(id) {
        Swal.fire({
            title: 'Anda yakin?',
            text: "Menghapus data ini menyebabkan data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = new FormData();
                form.append('action', 'hapus');
                form.append('_token', token);
                form.append('id', id)
                axios.post("{{url('admin/ajax/car')}}", form)
                    .then(response => {
                        $(".modalEdit").modal('hide');
                        if (response.data.status) {
                            setTimeout(function() {
                                swal.fire({
                                    text: response.data.message,
                                    icon: 'success',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok, got it!',
                                    customClass: {
                                        confirmButton: 'btn font-weight-bold btn-primary',
                                    },
                                }).then(function() {
                                    table.ajax.reload();
                                });
                            }, 200);
                        } else {
                            setTimeout(function() {
                                swal.fire({
                                    text: response.data.message,
                                    icon: 'error',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok lets check',
                                    customClass: {
                                        confirmButton: 'btn font-weight-bold btn-danger',
                                    },
                                });
                            }, 200);
                        }
                    })
                    .catch(error => {
                        $(".modalEdit").modal('hide')
                        if (error.response) {
                            const data = error.response.data;
                            var errorAjax = data.errors;
                            let errorMessage = '';
                            Object.keys(errorAjax).map(function(key) {
                                errorMessage += errorAjax[key][0] + '<br/>'
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: errorMessage,
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Server mengalami masalah!',
                            })
                        }
                    });
            }
        })
    }
</script>
@endsection