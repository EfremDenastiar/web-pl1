<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukModel;
use CodeIgniter\HTTP\Message;

class Produk extends BaseController
{
    // protected $produkmodel;

    // public function __construct()
    // {
    //     $this->produkmodel = new ProdukModel();
    // }
    public function index()
    {
        return view('V_produk');
    }

    public function simpan_produk()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_produk'   => 'required',
            'harga'         => 'required|decimal',
            'stok'          => 'required|integer',
            'gambar'      => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,2048]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status'    => 'error',
                'errors'    => $validation->getErrors(),
            ]);
        }

        $namaProduk = $this->request->getVar('nama_produk');
        $harga = $this->request->getVar('harga');
        $stok = $this->request->getVar('stok');
        $gambar = $this->request->getFile('gambar');
        $gambarName = null;

        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $gambarName = $gambar->getRandomName();
            $gambar->move(FCPATH . 'assets/uploads', $gambarName);
        }

        $data = [
            'nama_produk' => $namaProduk,
            'harga' => $harga,
            'stok' => $stok,
            'gambar' => $gambarName
        ];
        $produkmodel = new ProdukModel();

        $produkmodel->save($data);

        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => 'Data produk berhasil disimpan'
        ]);
    }
    public function getProduk($id)
    {
        $produkModel = new ProdukModel();
        $produk = $produkModel->find($id);

        if ($produk) {
            return $this->response->setJSON(['status' => 'success', 'produk' => $produk]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
        }
    }

    public function update($id)
    {
        $data = [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
        ];

        $produkModel = new ProdukModel();

        if ($produkModel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui produk']);
        }
    }

    // public function edit_produk()
    // {

    //     $nama = $this->request->getPost('namaProduk');
    //     $harga = $this->request->getPost('hargaProduk');
    //     $stok = $this->request->getPost('stokProduk');

    //     $produkmodel = new ProdukModel();

    //     $data = [
    //         'nama_produk' => $nama,
    //         'harga' => $harga,
    //         'stok' => $stok,
    //     ];

    //     if ($produkmodel->update($data)) {
    //         return $this->response->setJSON(['status' => 'success', 'message' => 'Produk Berhasil Disimpan']);
    //     }
    //     else {
    //         return $this->response->setJSON(['status' => 'error', 'message' => 'Produk Gagal Disimpan']);
    //     }
    // }

    public function tampil_produk()
    {
        $produkmodel = new ProdukModel();

        $produk = $produkmodel->findAll();

        return $this->response->setJSON([
            'status'    => 'success',
            'produk'    => $produk
        ]);
    }

    public function hapus($produk_id)
    {
        $produkModel = new ProdukModel();
        $hapus = $produkModel->delete($produk_id);

        if ($hapus) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Produk berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menghapus produk'
            ]);
        }
    }
    // public function hapus_produk()
    // {
    //     $productmodel = new ProdukModel();
    //     $productId = $this->request->getPost('product_id');

    //     if ($productmodel->delete($productId)) {
    //         return $this->response->setJSON([
    //             'status' => 'success',
    //             'message' => 'Produk berhasil dihapus'
    //         ]);
    //     } else {
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'Gagal menghapus produk'
    //         ]);
    //     }
    // }
}
