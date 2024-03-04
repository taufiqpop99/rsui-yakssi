<?php

namespace App\Controllers;

class Pasien extends BaseController
{
    protected $pasienModel;

    public function __construct()
    {
        $this->pasienModel = new \App\Models\PasienModel();
    }

    // List Pasien
    public function index()
    {
        $currentPage = $this->request->getVar('page_pages') ? $this->request->getVar('page_pages') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $pasien = $this->pasienModel->search($keyword);
        } else {
            $pasien = $this->pasienModel;
        }

        $pasien->orderBy('id', 'DESC');

        $data = [
            'title'       => 'RSUI YAKSSI | Pasien',
            'pasien'      => $pasien->paginate(5, 'pasien'),
            'pager'       => $pasien->pager,
            'currentPage' => $currentPage,
        ];

        // $_data = json_encode($data);
        // dd($data);
        // print_r($pasien->paginate(5, 'pasien'));
        return view('control/pasien/index', $data);
    }

    // Detail Pasien
    public function detail($id)
    {
        $data = [
            'title' => 'RSUI YAKSSI | Detail Pasien',
            'pasien' => $this->pasienModel->find($id),
        ];

        $db      = \Config\Database::connect();
        $builder = $db->table('pasien');
        $builder->select('id, key, value');
        $builder->where('id', $id);
        $query   = $builder->get();

        $data['pasien'] = $query->getResultArray();

        return view('control/pasien/detail', $data);
    }

    // Create Data
    public function form()
    {
        $data = [
            'title'      => 'RSUI YAKSSI | Form Pasien',
            'validation' => \Config\Services::validation()
        ];

        $db      = \Config\Database::connect();
        $builder = $db->table('pasien');
        $builder->select('id, key, value');
        $query   = $builder->get();

        $data['pasien'] = $query->getResultArray();

        return view('control/pasien/form', $data);
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
            return redirect()->to('control/pasien/form')->withInput()->with('validation', $validation);
        }

        // Ambil Gambar
        $gambarPages = $this->request->getFile('images');

        // Apakah Tidak Ada Gambar Yang Diupload
        if ($gambarPages->getError() == 4) {
            $namaGambar = 'default.svg';
        } else {
            // Generate Nama File Random
            $namaGambar = $gambarPages->getRandomName();

            // Pindahkan Gambar
            $gambarPages->move('img/pasien', $namaGambar);
        }

        $this->pasienModel->save([
            'judul'     => $this->request->getVar('judul'),
            'content'   => $this->request->getVar('content'),
            'images'    => $namaGambar,
        ]);

        session()->setFlashdata('pesan', 'Data Pasien Berhasil Ditambahkan!');

        return redirect('control/pasien');
    }

    // Edit Data
    public function edit($id)
    {
        $data = [
            'title'      => 'RSUI YAKKSI | Edit Data Pasien',
            'pasien'      => $this->pasienModel->find($id),
            'validation' => \Config\Services::validation()
        ];

        $db      = \Config\Database::connect();
        $builder = $db->table('pasien');
        $builder->select('id, judul, content, images');
        $builder->where('id', $id);
        $query   = $builder->get();

        $data['pasien'] = $query->getResultArray();

        return view('control/pasien/edit', $data);
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
            return redirect()->to('control/pasien/formEdit')->withInput()->with('validation', $validation);
        }

        $gambarPages = $this->request->getFile('images');

        // Cek Gambar, Apakah Tetap Gambar Lama
        if ($gambarPages->getError() == 4) {
            $namaGambar = $this->request->getVar('imgPagesLama');
        } else {
            // Generate Nama File Random
            $namaGambar = $gambarPages->getRandomName();

            // Pindahkan Gambar
            $gambarPages->move('img/pasien', $namaGambar);

            // Hapus File Yang Lama
            unlink('img/pasien/' . $this->request->getVar('imgPagesLama'));
        }

        $this->pasienModel->save([
            'id'      => $id,
            'judul'   => $this->request->getVar('judul'),
            'content' => $this->request->getVar('content'),
            'images'  => $namaGambar,
        ]);

        session()->setFlashdata('pesan', 'Data Pasien Berhasil Diubah!');

        return redirect('control/pasien');
    }

    // Delete Data
    public function delete($id)
    {
        // Cari Gambar Berdasarkan ID
        $pasien = $this->pasienModel->find($id);

        // Cek Jika File Gambar default.svg
        if ($pasien['images'] != 'default.svg') {
            // Hapus Gambar Permanen
            unlink('img/pasien/' . $pasien['images']);
        }

        $this->pasienModel->delete($id);
        session()->setFlashdata('pesan', 'Data Pasien Berhasil Dihapus!');

        return redirect('control/pasien');
    }
}
