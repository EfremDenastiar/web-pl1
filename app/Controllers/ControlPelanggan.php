<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelPelanggan;

class ControlPelanggan extends BaseController
{
    public function index()
    {
        return view('V_pelanggan');
    }
    public function getpelanggan()
    {
        $model = new ModelPelanggan();
        $data = $model->findAll();
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function simpan_pelanggan()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'nama_pelanggan' => 'required',
            'alamat_pelanggan' => 'required',
            'no_telp_pelanggan' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status'    => 'error',
                'errors'    => $validation->getErrors(),
            ]);
        }

        $data = [
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'alamat_pelanggan' => $this->request->getPost('alamat_pelanggan'),
            'no_telp_pelanggan' => $this->request->getPost('no_telp_pelanggan')
        ];

        $model = new ModelPelanggan();

        $model->save($data);
        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => 'Data produk berhasil disimpan'
        ]);
    }
    public function dataPelanggan($id) {
        $model = new ModelPelanggan();
        $dataPelanggan = $model->find($id);
        if ($dataPelanggan) {
            return $this->response->setJSON(['status' => 'success', 'dataPelanggan' => $dataPelanggan]);
        }
        else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }
    public function updatePelanggan($id) {
        $data = [
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'alamat_pelanggan' => $this->request->getPost('alamat_pelanggan'),
            'no_telp_pelanggan' => $this->request->getPost('no_telp_pelanggan'),
        ];

        $model = new ModelPelanggan();
        
        if ($model->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success', ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal Memperbarui Produk']);
        }

    }
}
