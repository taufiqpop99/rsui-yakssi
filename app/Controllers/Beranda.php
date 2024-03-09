<?php

namespace App\Controllers;

class Beranda extends BaseController
{
    protected $berandaModel;

    public function __construct()
    {
        $this->berandaModel = new \App\Models\BerandaModel();
    }

    // List Beranda
    public function index()
    {
        $currentPage = $this->request->getVar('page_beranda') ? $this->request->getVar('page_beranda') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $beranda = $this->berandaModel->search($keyword);
        } else {
            $beranda = $this->berandaModel;
        }

        $beranda->orderBy('id', 'ASC');

        $data = [
            'title'       => 'RSUI YAKSSI | Beranda',
            'beranda'     => $beranda->paginate(5, 'beranda'),
            'pager'       => $beranda->pager,
            'currentPage' => $currentPage,
        ];

        return view('control/beranda/index', $data);
    }

    // Create Data
    public function form()
    {
        $data = [
            'title'      => 'RSUI YAKSSI | Form Beranda',
            'validation' => \Config\Services::validation()
        ];

        $db      = \Config\Database::connect();
        $builder = $db->table('beranda');
        $builder->select('id, key, value');
        $query   = $builder->get();

        $data['beranda'] = $query->getResultArray();

        return view('control/beranda/form', $data);
    }

    // Insert Data
    public function insert($id = '')
    {
        // Validasi Input
        if (!$this->validate([
            'images' => [
                'rules'  => 'uploaded[images]|max_size[images,10240]|is_image[images]|mime_in[images,image/jpg,image/jpeg,image/png,image/svg]',
                'errors' => [
                    'uploaded' => 'Pilih Gambar Terlebih Dahulu',
                    'max_size' => 'Ukuran Gambar Terlalu Besar',
                    'is_image' => 'Yang Anda Pilih Bukan Gambar',
                    'mime_in'  => 'Yang Anda Pilih Bukan Gambar'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('control/beranda/form')->withInput()->with('validation', $validation);
        }

        // Ambil Gambar
        $gambarBeranda = $this->request->getFile('images');

        // Apakah Tidak Ada Gambar Yang Diupload
        if ($gambarBeranda->getError() == 4) {
            $namaGambar = 'default.svg';
        } else {
            // Generate Nama File Random
            $namaGambar = $gambarBeranda->getRandomName();

            // Pindahkan Gambar
            $gambarBeranda->move('img/beranda', $namaGambar);
        }

        $input = [
            'status'    => $this->request->getPost('status'),
            'header'    => $this->request->getPost('header'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'images'    => $namaGambar,
        ];

        $data = [
            'key'   => $this->request->getPost('header'),
            'value' => json_encode($input),
        ];

        $this->berandaModel->save($data);
        session()->setFlashdata('pesan', 'Data Beranda Berhasil Ditambahkan!');

        return redirect('control/beranda');
    }

    // Edit Data
    public function edit($id)
    {
        $data = [
            'title'      => 'RSUI YAKKSI | Edit Data Beranda',
            'beranda'      => $this->berandaModel->find($id),
            'validation' => \Config\Services::validation()
        ];

        $db      = \Config\Database::connect();
        $builder = $db->table('beranda');
        $builder->select('id, key, value, created_at, updated_at, deleted_at');
        $builder->where('id', $id);
        $query   = $builder->get();

        $data['beranda'] = $query->getResultArray();

        return view('control/beranda/edit', $data);
    }

    // Update Data
    public function update($id)
    {
        // Validasi Input
        if (!$this->validate([
            'images' => [
                'rules' => 'max_size[images,10240]|is_image[images]|mime_in[images,image/jpg,image/jpeg,image/png,image/svg]',
                'errors' => [
                    'max_size' => 'Ukuran Gambar Terlalu Besar',
                    'is_image' => 'Yang Anda Pilih Bukan Gambar',
                    'mime_in'  => 'Yang Anda Pilih Bukan Gambar'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('control/beranda/edit')->withInput()->with('validation', $validation);
        }

        $gambarBeranda = $this->request->getFile('images');

        // Cek Gambar, Apakah Tetap Gambar Lama
        if ($gambarBeranda->getError() == 4) {
            $namaGambar = $this->request->getVar('imgLama');
        } else {
            // Generate Nama File Random
            $namaGambar = $gambarBeranda->getRandomName();

            // Pindahkan Gambar
            $gambarBeranda->move('img/beranda', $namaGambar);

            // Hapus File Yang Lama
            unlink('img/beranda/' . $this->request->getVar('imgLama'));
        }

        $input = [
            'status'      => $this->request->getPost('status'),
            'header'      => $this->request->getPost('header'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'images'    => $namaGambar,
        ];

        $data = [
            'id'    => $id,
            'key'   => $this->request->getPost('header'),
            'value' => json_encode($input),
        ];

        $this->berandaModel->save($data);
        session()->setFlashdata('pesan', 'Data Beranda Berhasil Diubah!');

        return redirect('control/beranda');
    }

    // Delete Data
    public function delete($id)
    {
        // Cari Gambar Berdasarkan ID
        $beranda = $this->berandaModel->find($id);
        $berandaJSON = json_decode($beranda['value']);

        // Hapus Gambar Permanen
        unlink('img/beranda/' . $berandaJSON->images);

        $this->berandaModel->delete($id);
        session()->setFlashdata('pesan', 'Data Beranda Berhasil Dihapus!');

        return redirect('control/beranda');
    }
}