<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.6.0-web/css/all.min.css">
</head>

<body>
    <div class="container mt-3">
        <div class="col">
            <h2 class="text-center">Data Produk</h2>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-cart-plus"></i>Tambah Data</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="container mt-5">
                <table class="table table-bordered" id="produkTable">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>
                                Nama Produk
                            </th>
                            <th>
                                Harga
                            </th>
                            <th>
                                Stok
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <label for="namaProduk" class="col-sm-2 col-form-label">Nama Produk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="namaProduk">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hargaProduk" class="col-sm-2 col-form-label">Harga</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="hargaProduk">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="stokProduk" class="col-sm-2 col-form-label">Stok</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="stokProduk">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="gambarProduk" class="col-sm-2 col-form-label">Gambar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="gambarProduk" name="gambar" accept="image/*">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary float-end" id="simpanProduk">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <label for="namaProduk" class="col-sm-2 col-form-label">Nama Produk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editNamaProduk">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hargaProduk" class="col-sm-2 col-form-label">Harga</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editHargaProduk">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="stokProduk" class="col-sm-2 col-form-label">Stok</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editStokProduk">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary float-end" id="perbaruiProduk">Simpan</button>
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
            $("#simpanProduk").on("click", function() {
                var formData = new FormData();
                formData.append('nama_produk', $('#namaProduk').val());
                formData.append('harga', $('#hargaProduk').val());
                formData.append('stok', $('#stokProduk').val());

                var gambar = $('#gambarProduk')[0].files[0];
                if (gambar) {
                    formData.append('gambar', gambar)
                }

                $.ajax({
                    url: '<?= base_url('produk/simpan'); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(hasil) {
                        if (hasil.status === 'success') {
                            $('#namaProduk').val('');
                            $('#hargaProduk').val('');
                            $('#stokProduk').val('');
                            $('#gambarProduk').val('');

                            // Tutup modal
                            $('#staticBackdrop').modal('hide');

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

        $(document).on('click', '.editProduk', function() {
            var produkID = $(this).data('id');

            $.ajax({
                url: '<?= base_url('produk/getProduk'); ?>/' + produkID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        $('#editNamaProduk').val(data.produk.nama_produk);
                        $('#editHargaProduk').val(data.produk.harga);
                        $('#editStokProduk').val(data.produk.stok);
                        $('#perbaruiProduk').data('id', produkID);
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


        $('#perbaruiProduk').on('click', function() {
            var produkID = $(this).data('id');
            var formData = {
                nama_produk: $('#editNamaProduk').val(),
                harga: $('#editHargaProduk').val(),
                stok: $('#editStokProduk').val()
            };

            $.ajax({
                url: '<?= base_url('produk/update'); ?>/' + produkID,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(hasil) {
                    if (hasil.status === 'success') {
                        $('#updateProduk').modal('hide'); // Menutup modal setelah sukses
                        tampilProduk(); // Memperbarui tampilan tabel
                    } else {
                        alert('Gagal memperbarui data: ' + JSON.stringify(hasil.errors));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
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
                url: '<?= base_url('produk/tampil') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(hasil) {
                    if (hasil.status === 'success') {
                        var produkTable = $('#produkTable tbody');
                        produkTable.empty();

                        var produk = hasil.produk;
                        var no = 1;

                        produk.forEach(function(item) {
                            var gambar = item.gambar ?
                                '<img src="<?= base_url('assets/uploads/'); ?>' + item.gambar + '" style="max-width: 100px;">' :
                                'Tidak ada gambar';

                            var row = '<tr>' +
                                '<td>' + no + '</td>' +
                                '<td>' + item.nama_produk + '</td>' +
                                '<td>' + item.harga + '</td>' +
                                '<td>' + item.stok + '</td>' +
                                '<td>' + gambar + '</td>' +
                                '<td>' +
                                '<button class="btn btn-warning btn-sm editProduk" data-bs-toggle="modal" data-bs-target="#updateProduk" data-id="' + item.produk_id + '"><i class="fa-solid fa-pencil"></i>Edit</button>' +
                                '&nbsp;' +
                                '<button class="btn btn-danger btn-sm hapusProduk" data-id="' + item.produk_id + '"><i class="fa-solid fa-trash-can"></i>Hapus</button>' +
                                '</td>' +
                                '</tr>';
                            produkTable.append(row);
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