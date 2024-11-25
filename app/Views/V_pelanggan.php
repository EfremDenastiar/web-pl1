<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.6.0-web/css/all.min.css">
</head>

<body>
    <div class="container mt-3">
        <div class="col">
            <h2 class="text-center">Data Pelanggan</h2>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahPelanggan"><i class="fa-solid fa-cart-plus"></i>Tambah Data</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="container mt-5">
                <table class="table table-bordered" id="pelangganTable">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>
                                Nama Pelanggan
                            </th>
                            <th>
                                Alamat
                            </th>
                            <th>
                                No. Telp
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahPelanggan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Pelanggan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <label for="namaPelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="namaPelanggan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamatPelanggan" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamatPelanggan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="telpPelanggan" class="col-sm-2 col-form-label">No. Telp</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="telpPelanggan">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary float-end" id="simpanData">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updatePelanggan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Data Pelanggan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <label for="namaPelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editNamaPelanggan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamatPelanggan" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editAlamatPelanggan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="telpPelanggan" class="col-sm-2 col-form-label">No. Telp</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editTelpPelanggan">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary float-end" id="perbaruiData">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            tampilProduk();
            $("#simpanData").on("click", function() {
                var formData = {
                    nama_pelanggan: $('#namaPelanggan').val(),
                    alamat_pelanggan: $('#alamatPelanggan').val(),
                    no_telp_pelanggan: $('#telpPelanggan').val()
                };

                $.ajax({
                    url: '<?= base_url('pelanggan/simpan'); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(hasil) {
                        if (hasil.status === 'success') {
                            $('#namaPelanggan').val('');
                            $('#alamatPelanggan').val('');
                            $('#telpPelanggan').val('');

                            // Tutup modal
                            $('#tambahPelanggan').modal('hide');
                            Swal.fire({
                                icon: "success",
                                title: "Datamu Berhasil Disimpan!",
                                showConfirmButton: false,
                                timer: 2000
                            });

                            // Refresh tampilan tabel
                            tampilProduk();
                        } else {
                            alert('Gagal menyimpan data: ' + JSON.stringify(hasil.errors));
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                })
            })
        })

        $(document).on('click', '.editDataPelanggan', function() {
            var IDpelanggan = $(this).data('id');
            console.log("id pelanggan: " + IDpelanggan);

            $.ajax({
                url: '<?= base_url('pelanggan/getDataPelanggan'); ?>/' + IDpelanggan,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        $('#editNamaPelanggan').val(data.dataPelanggan.nama_pelanggan);
                        $('#editAlamatPelanggan').val(data.dataPelanggan.alamat_pelanggan);
                        $('#editTelpPelanggan').val(data.dataPelanggan.no_telp_pelanggan);
                        $('#perbaruiData').data('id', IDpelanggan);
                    } else {
                        alert('Gagal mengambil data produk');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        });

        $(document).on("click", ".hapusProduk", function() {
            var produkID = $(this).data('id');

            if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
                $.ajax({
                    url: '<?= base_url('produk/hapus'); ?>/' + produkID,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        produk_id: produkID
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            alert('Produk berhasil dihapus!');
                            tampilProduk();
                        } else {
                            alert('Gagal menghapus produk');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            }
        });


        $('#perbaruiData').on('click', function() {
    var IDpelanggan = $(this).data('id');
    console.log('id: ' + IDpelanggan);
    var formData = {
        nama_pelanggan: $('#editNamaPelanggan').val(),
        alamat_pelanggan: $('#editAlamatPelanggan').val(),
        no_telp_pelanggan: $('#editTelpPelanggan').val()
    };

    Swal.fire({
        title: "Apakah Anda ingin menyimpan perubahan?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Simpan",
        denyButtonText: "Batalkan"
    }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
                url: '<?= base_url('pelanggan/update'); ?>/' + IDpelanggan,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(hasil) {
                    if (hasil.status === 'success') {
                        $('#updatePelanggan').modal('hide');

                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data berhasil diperbarui",
                            icon: "success"
                        });

                        tampilProduk(); 
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal memperbarui data: " + JSON.stringify(hasil.errors),
                            icon: "error"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: "Error!",
                        text: "Terjadi kesalahan: " + error,
                        icon: "error"
                    });
                }
            });
        } else if (result.isDenied) {
            Swal.fire({
                title: "Perubahan Dibatalkan",
                text: "Data tidak jadi diperbarui",
                icon: "info"
            });
            $('#updatePelanggan').modal('hide');
        }
    });
});

        // function hapusProduct(productId) {

        //     if (confirm("Anda yakin ingin menghapus produk ini?")) {
        //         $.ajax({
        //             url: '<?= base_url('product/hapus'); ?>',
        //             type: 'POST',
        //             data: { product_id: productId },
        //             dataType: 'json',
        //             success: function(hasil) {
        //                 if (hasil.status === 'success') {
        //                     alert("Produk berhasil dihapus!");
        //                     tampilProduct(); 
        //                 } else {
        //                     alert("Gagal menghapus produk: " + hasil.message);
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 alert("Terjadi kesalahan: " + error);
        //             }
        //         });
        //         }
        //     }

        function tampilProduk() {
            $.ajax({
                url: '<?= base_url('pelanggan/tampil') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(hasil) {
                    console.log(hasil)
                    if (hasil.status === 'success') {
                        var tampilanPelanggan = $('#pelangganTable tbody');
                        tampilanPelanggan.empty();

                        var data = hasil.data
                        var no = 1;

                        data.forEach(function(item) {
                            var row = '<tr>' +
                                '<td>' + no + '</td>' +
                                '<td>' + item.nama_pelanggan + '</td>' +
                                '<td>' + item.alamat_pelanggan + '</td>' +
                                '<td>' + item.no_telp_pelanggan + '</td>' +
                                '<td>' +
                                '<button class="btn btn-warning btn-sm editDataPelanggan" data-bs-toggle="modal" data-bs-target="#updatePelanggan" data-id="' + item.id_pelanggan + '"><i class="fa-solid fa-pencil"></i> Edit</button>' +
                                '&nbsp;' +
                                '<button class="btn btn-danger btn-sm hapusDataPelanggan" data-id="' + item.id_pelanggan + '"><i class="fa-solid fa-trash-can"></i> Hapus</button>' +
                                '</td>' +
                                '</tr>';
                            tampilanPelanggan.append(row);
                            no++;
                        });
                    } else {
                        alert('Gagal Mengambil Data.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        }
    </script>
</body>

</html>