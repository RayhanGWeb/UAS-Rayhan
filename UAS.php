<?php
// Class Pegawai
class Pegawai {
    public $no;
    public $nama;
    public $unitPendidikan;
    public $tanggalGaji;
    public $jabatan;
    public $lamaKerja;
    public $statusKerja;
    public $gaji;
    public $bonus;
    public $bpjs;
    public $pinjaman;
    public $cicilan;
    public $infaq;

    public function __construct($no, $nama, $unitPendidikan, $tanggalGaji, $jabatan, $lamaKerja, $statusKerja, $bpjs, $pinjaman, $cicilan, $infaq) {
        $this->no = $no;
        $this->nama = $nama;
        $this->unitPendidikan = $unitPendidikan;
        $this->tanggalGaji = $tanggalGaji;
        $this->jabatan = $jabatan;
        $this->lamaKerja = $lamaKerja;
        $this->statusKerja = $statusKerja;
        $this->bpjs = $bpjs;
        $this->pinjaman = $pinjaman;
        $this->cicilan = $cicilan;
        $this->infaq = $infaq;
        $this->setGajiBonus();
    }

    private function setGajiBonus() {
        switch ($this->jabatan) {
            case 'Kepala Sekolah':
                $this->gaji = 10000000;
                break;
            case 'Wakasek':
                $this->gaji = 7000000;
                break;
            case 'Guru':
                $this->gaji = 5000000;
                break;
            case 'Karyawan':
                $this->gaji = 2500000;
                break;
        }
        $this->bonus = ($this->statusKerja == 'Tetap') ? 1000000 : 0;
    }

    public function hitungGajiBersih() {
        return ($this->gaji + $this->bonus) - ($this->bpjs + $this->pinjaman + $this->cicilan + $this->infaq);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penggajian Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="text-center mb-5">
        <img src="LOGO SMK ASSALAM.png" alt="" width="28%">
        <h3>PENGGAJIAN GURU/KARYAWAN</h3>
        <h4>YAYASAN ASSALAAM</h4>
    </div>

    <!-- Form Input -->
    <form method="POST" class="border p-4 shadow-sm rounded">
        <div class="row">
            <!-- Data Penggajian Card -->
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Data Penggajian</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">No</label>
                            <input type="text" class="form-control" name="no" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Unit Pendidikan</label>
                            <select class="form-control" name="unitPendidikan">
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="SMK">SMK</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Gaji</label>
                            <input type="date" class="form-control" name="tanggalGaji" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gaji and Potongan Cards -->
            <div class="col-md-6 mb-4">
                <!-- Gaji Card (Left) -->
                <div class="card">
                    <div class="card-header">
                        <h5>Gaji</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <select class="form-control" name="jabatan">
                                <option value="Kepala Sekolah">Kepala Sekolah</option>
                                <option value="Wakasek">Wakasek</option>
                                <option value="Guru">Guru</option>
                                <option value="Karyawan">Karyawan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lama Kerja (Tahun)</label>
                            <input type="number" class="form-control" name="lamaKerja" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Kerja</label>
                            <select class="form-control" name="statusKerja">
                                <option value="Tetap">Tetap</option>
                                <option value="Kontrak">Kontrak</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <!-- Potongan Card (Right) -->
                <div class="card">
                    <div class="card-header">
                        <h5>Potongan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">BPJS</label>
                            <input type="number" class="form-control" name="bpjs" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pinjaman</label>
                            <input type="number" class="form-control" name="pinjaman" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cicilan</label>
                            <input type="number" class="form-control" name="cicilan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Infaq</label>
                            <input type="number" class="form-control" name="infaq" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <center>
        <button type="submit" class="btn btn-primary">Proses</button>
        </center>
    </form>

    <!-- Output Struk -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pegawai = new Pegawai(
            $_POST['no'],
            $_POST['nama'],
            $_POST['unitPendidikan'],
            $_POST['tanggalGaji'],
            $_POST['jabatan'],
            $_POST['lamaKerja'],
            $_POST['statusKerja'],
            $_POST['bpjs'],
            $_POST['pinjaman'],
            $_POST['cicilan'],
            $_POST['infaq']
        );

        $gajiBersih = $pegawai->hitungGajiBersih();
        echo "
        <div class='row mt-5'>
            <div class='col-md-8 mx-auto'>
                <div class='card'>
                    <div class='card-header text-center'>
                        <h5>STRUK GAJI</h5>
                    </div>
                    <div class='card-body'>
                        <p>No: {$pegawai->no}</p>
                        <p>Nama: {$pegawai->nama}</p>
                        <p>Unit Pendidikan: {$pegawai->unitPendidikan}</p>
                        <p>Tanggal Gaji: {$pegawai->tanggalGaji}</p>
                        <p>Jabatan: {$pegawai->jabatan}</p>
                        <p>Gaji: Rp. " . number_format($pegawai->gaji, 0, ',', '.') . "</p>
                        <p>Bonus: Rp. " . number_format($pegawai->bonus, 0, ',', '.') . "</p>
                        <p>BPJS: Rp. " . number_format($pegawai->bpjs, 0, ',', '.') . "</p>
                        <p>Pinjaman: Rp. " . number_format($pegawai->pinjaman, 0, ',', '.') . "</p>
                        <p>Cicilan: Rp. " . number_format($pegawai->cicilan, 0, ',', '.') . "</p>
                        <p>Infaq: Rp. " . number_format($pegawai->infaq, 0, ',', '.') . "</p>
                        <p><strong>Gaji Bersih: Rp. " . number_format($gajiBersih, 0, ',', '.') . "</strong></p>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
