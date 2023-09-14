@extends('template')
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
<div class="mt-4">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <h5>Sewa Cepat</h5>
            </div>
            <div class="card-body">
                <form role="form" id="rent">
                    <div class="form-group mb-3">
                        <label>List Merk</label>
                        <select class="form-select" id="brand" name="brand">
                            <option value="null"> Silahkan Pilih Merk --</option>
                            @foreach($filter_brand as $fb)
                            <option value="{{$fb['brand'] }}"> {{ $fb['brand'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>List Model</label>
                        <select class="form-select" id="model" name="model">
                            <option value="null"> Silahkan Pilih Model --</option>
                        </select>
                    </div>
                    <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Tanggal Mulai Sewa</label>
                        <input type="date" class="form-control" name="date_start_rent" />
                    </div>
                    <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Estimasi Penyewaan (dalam satuan hari)</label>
                        <input type="number" class="form-control" name="est_rent" />
                    </div>
                    <button class="btn btn-primary" type="submit" id="submit_btn">Sewa Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $("#brand").on('change', function() {
        var val = $(this).val()
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{url('data/get-model')}}",
            data: {
                brand: val,
                _token: token
            },
            success: function(data) {
                let dataModel = `<option value="null">Silahkan Pilih Model</option>`;
                for (const model of data.data) {
                    dataModel += `<option value="${model.id}">${model.model} Nompol (${model.number_plate})</option>`;
                }
                $("#model").html(dataModel)
            }
        })
    })
    $("#rent").submit(function(e) {
        e.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post(`{{ url('ajax/rent') }}`, form)
            .then(result => {
                if (!result.data.status) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: result.data.message,
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Menyewa Mobil!',
                        text: 'Anda Bisa Melihat Data Mobil yang anda sewa di menu Mobil Sewa',
                        showConfirmButton: false,
                        timer: 2500
                    }).then(function() {
                        // window.location.href = "{{ url('/') }}"
                    });
                }
                $("#submit_btn").attr('disabled', false);
                $("#submit_btn").html('Sewa Sekarang');
            }).catch(error => {
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
                $("#submit_btn").attr('disabled', false);
                $("#submit_btn").html('Sewa Sekarang');
            })
    })
</script>
@endsection