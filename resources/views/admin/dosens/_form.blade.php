{{-- resources/views/admin/dosens/_form.blade.php --}}
@props(['dosen' => null])

<div class="row">
    <div class="col-md-6">
        <x-forms.input name="nidn" label="NIDN" :value="$dosen->nidn ?? ''" required />
    </div>

    <div class="col-md-6">
        <x-forms.input name="nik" label="NIK" :value="$dosen->nik ?? ''" required />
    </div>

    <div class="col-md-6">
        <x-forms.input name="nama" label="Nama Lengkap" :value="$dosen->nama ?? ''" required />
    </div>

    <div class="col-md-6">
        <x-forms.input name="email" label="Email" type="email" :value="$dosen->email ?? ''" required />
    </div>

    <div class="col-md-6">
        <x-forms.select name="status" label="Status" :options="['tetap' => 'Tetap', 'kontrak' => 'Kontrak', 'luar_biasa' => 'Luar Biasa', 'pensiun' => 'Pensiun']" :selected="$dosen->status ?? ''" required />
    </div>

    <div class="col-md-6">
        <x-forms.select name="pendidikan_terakhir" label="Pendidikan Terakhir" :options="['S1' => 'S1', 'S2' => 'S2', 'S3' => 'S3']" :selected="$dosen->pendidikan_terakhir ?? ''"
            required />
    </div>

    <div class="col-md-6">
        <x-forms.input name="jabatan_fungsional" label="Jabatan Fungsional" :value="$dosen->jabatan_fungsional ?? ''" required />
    </div>

    <div class="col-md-6">
        <x-forms.input name="inpassing" label="Inpassing" :value="$dosen->inpassing ?? ''" required />
    </div>

    <div class="col-md-6">
        <x-forms.input name="kepangkatan" label="Kepangkatan" :value="$dosen->kepangkatan ?? ''" required />
    </div>

    <div class="col-md-6">
        <x-forms.file-upload name="photo" label="Foto" :file="$dosen->photo ?? null" accept="image/*" />
    </div>
</div>
