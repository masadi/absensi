<?php

namespace App\Http\Livewire;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Absen;
use App\Models\Absen_masuk;
use App\Models\Absen_pulang;
use App\Models\Setting;
use App\Models\Jam;
use Carbon\Carbon;
use File;
use Storage;

class Absensi extends Component
{
    /*
    $now = Carbon::now();
    $start = Carbon::createFromTimeString('22:00');
    $end = Carbon::createFromTimeString('08:00');
    */
    use LivewireAlert, WithFileUploads;
    public $jarak_pengguna;
    public $jarak_pengaturan;
    public $status = 0;
    public $data = '';
    public $masuk = '';
    public $pulang = '';
    public $now = '';
    public $scan_masuk_start = '';
    public $scan_masuk_end = '';
    public $scan_pulang_start = '';
    public $scan_pulang_end = '';
    public $disabled_masuk = 'disabled';
    public $disabled_pulang = 'disabled';
    public $aktifitas_masuk = 'Belum ada aktifitas';
    public $aktifitas_pulang = 'Belum ada aktifitas';
    public $keterangan;
    public $dokumen;
    public function getListeners()
    {
        return [
            'confirmed',
            'pulang_awal',
            'konfirmasi'
        ];
    }
    public function absen($data)
    {
        $this->data = $data;
        if($data == 'pulang' && $this->now->diffInSeconds($this->scan_pulang_start, false) > 0){
            $this->alert('warning', 'Anda Yakin akan Absen '.ucfirst($data).'?', [
                'text' => 'Anda terdeteksi pulang lebih awal',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Ya',
                'showCancelButton' => true,
                'cancelButtonText' => 'Batal',
                'onConfirmed' => 'pulang_awal',
                'onDismissed' => 'cancelled',
                'allowOutsideClick' => false,
                'timer' => null
            ]);
        } else {
            $this->alert('warning', 'Anda Yakin akan Absen '.ucfirst($data).'?', [
                'showConfirmButton' => true,
                'confirmButtonText' => 'Ya',
                'showCancelButton' => true,
                'cancelButtonText' => 'Batal',
                'onConfirmed' => 'confirmed',
                'onDismissed' => 'cancelled',
                'allowOutsideClick' => false,
                'timer' => null
            ]);
        }
    }
    public function confirmed()
    {
        $user = auth()->user();
        $absen = Absen::where(function($query) use ($user){
            $query->whereDate('created_at', Carbon::today());
            $query->where('ptk_id', $user->ptk->ptk_id);
            $query->where('semester_id', session('semester_aktif'));
        })->first();
        if(!$absen){
            $absen = Absen::create([
                'ptk_id' => $user->ptk->ptk_id,
                'semester_id' => session('semester_aktif'),
            ]);
        }
        if($this->data == 'masuk'){
            Absen_masuk::updateOrCreate([
                'absen_id' => $absen->id,
                'keterangan' => $this->keterangan,
                'dokumen' => $this->dokumen,
            ]);
        } else {
            Absen_pulang::updateOrCreate([
                'absen_id' => $absen->id,
                'keterangan' => $this->keterangan,
                'dokumen' => $this->dokumen,
            ]);
        }
        //$this->status = 'status '.$this->data.':'.session('semester_aktif');
        $this->alert('info', 'Absen '.ucfirst($this->data).' berhasil disimpan', [
            'position' => 'center'
        ]);
    }
    /*
    const { value: formValues } = await Swal.fire({
    title: 'Multiple inputs',
    html:
        '<input id="swal-input1" class="swal2-input">' +
        '<input id="swal-input2" class="swal2-input">',
    focusConfirm: false,
    preConfirm: () => {
        return [
        document.getElementById('swal-input1').value,
        document.getElementById('swal-input2').value
        ]
    }
    })

    if (formValues) {
    Swal.fire(JSON.stringify(formValues))
    }
    */
    public function pulang_awal(){
        $this->alert('', 'Isi Formulir Pulang Cepat', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Ya',
            'showCancelButton' => true,
            'cancelButtonText' => 'Batal',
            'onConfirmed' => 'konfirmasi',
            'onDismissed' => 'cancelled',
            'allowOutsideClick' => false,
            'willOpen' => "() => {
                $('#swal-input2').change(function () {
                    var reader = new FileReader();
                    reader.readAsDataURL(this.files[0]);
                    reader.onloadend = function(event){
                        $('#swal-input3').val(event.target.result);
                    }
                });
            }",
            'timer' => null,
            'html' => '
                <p>Isi keterangan pulang cepat dan unggah dokumen pendukung (jika ada)</p>
                <form class="was-validated">
                    <textarea id="swal-input1" class="form-control mb-2 is-invalid" placeholder="Keterangan pulang cepat" required></textarea>
                    <div class="invalid-feedback d-none">
                        Keterangan tidak boleh kosong
                    </div>
                    <input type="file" id="swal-input2" class="form-control">
                    <input type="hidden" id="swal-input3" class="swal2-input">
                </form>',
            'preConfirm' => "() => {
                if(document.getElementById('swal-input1').value){
                    return {
                        'keterangan' : document.getElementById('swal-input1').value,
                        'dokumen' : document.getElementById('swal-input3').value,
                    }
                } else {
                    $('.invalid-feedback').removeClass('d-none')
                    return false
                }
            }",
        ]);
    }
    public function konfirmasi($data){
        $image_64 = $data['value']['dokumen']; //your base64 encoded data
        if($image_64){
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64); 
            $image = str_replace(' ', '+', $image); 
            $imageName = Str::random(10).'.'.$extension;
            //$fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $extension;
            $this->dokumen = $imageName;
            Storage::disk('public')->put($imageName, base64_decode($image));
        }
        $this->keterangan = $data['value']['keterangan'];
        $this->confirmed();
    }
    public function render()
    {
        $user = auth()->user();
        $this->now = Carbon::now();
        $this->masuk = Absen_masuk::whereHas('absen', function($query) use ($user){
            $query->where('ptk_id', $user->ptk->ptk_id);
            $query->whereDate('created_at', Carbon::today());
        })->first();
        $this->pulang = Absen_pulang::whereHas('absen', function($query) use ($user){
            $query->where('ptk_id', $user->ptk->ptk_id);
            $query->whereDate('created_at', Carbon::today());
        })->first();
        $jarak = config('settings.jarak');
        $jam = Jam::where(function($query) use ($user){
            $query->whereHas('kategori', function($query) use ($user){
                $query->where('sekolah_id', $user->sekolah_id);
                $query->where('is_libur', 0);
            });
        })->first();
        if($jam){
            $this->scan_masuk_start = ($jam) ? Carbon::createFromTimeString($jam->scan_masuk_start) : '';
            $this->scan_masuk_end = ($jam) ? Carbon::createFromTimeString($jam->scan_masuk_end) : '';
            $this->scan_pulang_start = ($jam) ? Carbon::createFromTimeString($jam->scan_pulang_start) : '';
            $this->scan_pulang_end = ($jam) ? Carbon::createFromTimeString($jam->scan_pulang_end) : '';
            if ($this->now->between($this->scan_masuk_start, $this->scan_masuk_end) && !$this->masuk) {
                $this->disabled_masuk = '';
            }
            if ($this->now->between($this->scan_pulang_start, $this->scan_pulang_end) && !$this->pulang) {
                $this->disabled_pulang = '';
            }
            if($this->masuk){
                $this->disabled_masuk = 'disabled';
                $this->disabled_pulang = '';
                $this->aktifitas_masuk = Carbon::createFromTimeStamp(strtotime($this->masuk->created_at))->format('H:i');
            }
            if($this->pulang){
                $this->disabled_pulang = 'disabled';
                $this->aktifitas_pulang = Carbon::createFromTimeStamp(strtotime($this->pulang->created_at))->format('H:i');
            }
            if($jarak && session('jarak') > $jarak){
                $this->disabled_masuk = 'disabled';
                $this->disabled_pulang = 'disabled';
                $this->status = 'Jarak Anda dengan sekolah lebih dari '.$jarak.' meter';
            }
        } else {
            $this->disabled_masuk = 'disabled';
            $this->disabled_pulang = 'disabled';
            $this->status = 'Aplikasi belum di atur oleh Administrator. Silahkan hubungi Administrator untuk mengatur aplikasi!';
        }
        $this->jarak_pengguna = session('jarak');
        $this->jarak_pengaturan = $jarak;
        return view('livewire.absensi');
    }
}
