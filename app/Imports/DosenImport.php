<?php
// app/Imports/DosenImport.php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DosenImport implements ToCollection, WithStartRow
{
    protected $successCount = 0;
    protected $failCount = 0;
    protected $errors = [];
    protected $skippedCount = 0;

    public function startRow(): int
    {
        return 2; // Mulai dari baris ke-2 (baris 1 adalah header)
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;

            // Lewati baris yang kosong
            $isRowEmpty = true;
            foreach ($row as $cell) {
                if (!empty(trim((string) $cell))) {
                    $isRowEmpty = false;
                    break;
                }
            }

            if ($isRowEmpty) {
                $this->skippedCount++;
                continue;
            }

            // Ambil data (bersihkan spasi)
            $nidn = trim((string) ($row[0] ?? ''));
            $nik = trim((string) ($row[1] ?? ''));
            $nama = trim((string) ($row[2] ?? ''));
            $email = trim((string) ($row[3] ?? ''));
            $status = strtolower(trim((string) ($row[4] ?? 'tetap')));
            $pendidikan = strtoupper(trim((string) ($row[5] ?? 'S1')));
            $jabatan = trim((string) ($row[6] ?? ''));
            $inpassing = trim((string) ($row[7] ?? ''));
            $kepangkatan = trim((string) ($row[8] ?? ''));
            $bidang = trim((string) ($row[9] ?? ''));

            // Validasi field wajib
            if (empty($nidn) || empty($nik) || empty($nama) || empty($email)) {
                $this->failCount++;
                $this->errors[] = "Baris {$rowNumber}: NIDN, NIK, Nama, dan Email wajib diisi.";
                continue;
            }

            // Validasi format email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->failCount++;
                $this->errors[] = "Baris {$rowNumber}: Format email tidak valid ({$email}).";
                continue;
            }

            // Cek duplikat
            if (Dosen::where('nidn', $nidn)->exists()) {
                $this->failCount++;
                $this->errors[] = "Baris {$rowNumber}: NIDN {$nidn} sudah ada di database.";
                continue;
            }
            if (Dosen::where('nik', $nik)->exists()) {
                $this->failCount++;
                $this->errors[] = "Baris {$rowNumber}: NIK {$nik} sudah ada di database.";
                continue;
            }
            if (Dosen::where('email', $email)->exists()) {
                $this->failCount++;
                $this->errors[] = "Baris {$rowNumber}: Email {$email} sudah ada di database.";
                continue;
            }

            // Validasi status & pendidikan
            if (!in_array($status, ['tetap', 'kontrak', 'luar_biasa', 'pensiun'])) $status = 'tetap';
            if (!in_array($pendidikan, ['S1', 'S2', 'S3'])) $pendidikan = 'S1';

            try {
                // Simpan ke tabel dosens
                $dosen = Dosen::create([
                    'nidn' => $nidn, // NIDN sesuai inputan tanpa ditambah 0
                    'nik' => $nik,
                    'nama' => $nama,
                    'email' => $email,
                    'status' => $status,
                    'pendidikan_terakhir' => $pendidikan,
                    'jabatan_fungsional' => $jabatan ?: 'Tenaga Pengajar',
                    'inpassing' => $inpassing ?: '-',
                    'kepangkatan' => $kepangkatan ?: '-',
                    'bidang_keahlian' => $bidang ?: 'Psikologi',
                ]);

                // Buat akun user (Password = NIK)
                User::create([
                    'name' => $dosen->nama,
                    'email' => $dosen->email,
                    'password' => Hash::make($dosen->nik),
                    'role' => 'dosen',
                    'status' => 'active',
                    'dosen_id' => $dosen->id,
                ]);

                $this->successCount++;
            } catch (\Exception $e) {
                $this->failCount++;
                $this->errors[] = "Baris {$rowNumber}: " . $e->getMessage();
            }
        }
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }
    public function getFailCount(): int
    {
        return $this->failCount;
    }
    public function getSkippedCount(): int
    {
        return $this->skippedCount;
    }
    public function getErrors(): array
    {
        return $this->errors;
    }
}
