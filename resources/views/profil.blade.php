@extends('layouts.app')

@section('title', 'Profil Guru - Katrol.Lab')

@section('header_actions')
    <a href="{{ route('simulator.index') }}" class="btn btn-secondary btn-sm">
        Kembali ke Simulator
    </a>
@endsection

@section('content')
<div x-data="profilApp(@js($profil))" x-init="init()" style="height: 100%; overflow-y: auto; padding: 40px 24px; max-width: 900px; margin: 0 auto;">

    <!-- TOAST NOTIFIKASI -->
    <div
        x-show="toast.tampil"
        x-transition:enter="transition"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="toast"
        :class="toast.sukses ? 'toast-sukses' : 'toast-gagal'"
        style="display:none;"
    >
        <span style="width:7px; height:7px; border-radius:50%; background:currentColor; flex-shrink:0;"></span>
        <span x-text="toast.pesan"></span>
    </div>

    <!-- HEADER PROFIL GURU -->
    <div class="card" style="padding: 24px; margin-bottom: 24px; display: flex; align-items: center; gap: 20px;">
        <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--accent); color: #000; font-family: var(--font-display); font-size: 26px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <span x-text="inisialGuru"></span>
        </div>
        <div style="flex: 1; min-width: 0;">
            <h1 style="font-family: var(--font-display); font-size: 22px; font-weight: 800; color: var(--paper); line-height: 1.2;" x-text="form.nama || 'Nama Guru Belum Diisi'"></h1>
            <div style="font-size: 13px; color: var(--paper-dim); margin-top: 4px; display: flex; gap: 12px; flex-wrap: wrap;">
                <span x-text="form.mapel ? 'Mapel: ' + form.mapel : 'Mata Pelajaran Belum Diatur'"></span>
                <span>&bull;</span>
                <span x-text="form.sekolah ? form.sekolah : 'Sekolah Belum Diatur'"></span>
            </div>
        </div>
    </div>

    <form @submit.prevent="simpanProfil()">

        <!-- PANEL 1: IDENTITAS GURU & KELAS -->
        <div class="card" style="padding: 24px; margin-bottom: 20px;">
            <div class="label-caps" style="color: var(--accent); margin-bottom: 16px;">Panel A: Identitas Guru & Kelas</div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        Nama Lengkap Guru <span style="color: var(--accent);">*</span>
                    </label>
                    <input
                        type="text"
                        x-model="form.nama"
                        placeholder="Contoh: Drs. Bambang Sutrisno, M.Pd."
                        class="input-box"
                        style="width: 100%;"
                        required
                        maxlength="100"
                    >
                </div>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        NIP / NUPTK (Opsional)
                    </label>
                    <input
                        type="text"
                        x-model="form.nip"
                        placeholder="Contoh: 19820415 200801 1 007"
                        class="input-box"
                        style="width: 100%;"
                        maxlength="50"
                    >
                </div>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        Asal Satuan Pendidikan / Sekolah
                    </label>
                    <input
                        type="text"
                        x-model="form.sekolah"
                        placeholder="Contoh: SMAN 1 Indonesia Maju"
                        class="input-box"
                        style="width: 100%;"
                        maxlength="150"
                    >
                </div>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        Mata Pelajaran yang Diampu
                    </label>
                    <input
                        type="text"
                        x-model="form.mapel"
                        placeholder="Contoh: Matematika Wajib"
                        class="input-box"
                        style="width: 100%;"
                        maxlength="100"
                    >
                </div>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        Rombongan Belajar / Kelas
                    </label>
                    <input
                        type="text"
                        x-model="form.kelas"
                        placeholder="Contoh: XII MIPA 2"
                        class="input-box"
                        style="width: 100%;"
                        maxlength="50"
                    >
                </div>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        Tahun Ajaran (Format: YYYY/YYYY)
                    </label>
                    <input
                        type="text"
                        x-model="form.tahun_ajaran"
                        placeholder="2024/2025"
                        class="input-box"
                        style="width: 100%;"
                        pattern="^\d{4}/\d{4}$"
                        title="Gunakan format 4 digit garis miring 4 digit (misal: 2024/2025)"
                        maxlength="20"
                    >
                </div>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        Semester
                    </label>
                    <select x-model="form.semester" class="input-box" style="width: 100%;">
                        <option value="Ganjil">Semester Ganjil</option>
                        <option value="Genap">Semester Genap</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- PANEL 2: PREFERENSI DEFAULT SIMULATOR -->
        <div class="card" style="padding: 24px; margin-bottom: 24px;">
            <div class="label-caps" style="color: var(--accent); margin-bottom: 16px;">Panel B: Standar Default Simulator</div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        Default KKM
                    </label>
                    <input
                        type="number"
                        x-model.number="form.default_kkm"
                        min="0"
                        max="100"
                        class="input-box"
                        style="width: 100%;"
                        required
                    >
                </div>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        Bobot PH (%)
                    </label>
                    <input
                        type="number"
                        x-model.number="form.default_bobot_ph"
                        min="0"
                        max="100"
                        class="input-box"
                        style="width: 100%;"
                        required
                    >
                </div>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        Bobot PTS (%)
                    </label>
                    <input
                        type="number"
                        x-model.number="form.default_bobot_pts"
                        min="0"
                        max="100"
                        class="input-box"
                        style="width: 100%;"
                        required
                    >
                </div>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        Bobot PAS (%)
                    </label>
                    <input
                        type="number"
                        x-model.number="form.default_bobot_pas"
                        min="0"
                        max="100"
                        class="input-box"
                        style="width: 100%;"
                        required
                    >
                </div>
            </div>

            <!-- Indikator Total Bobot -->
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: var(--surface); border: 1px solid var(--border); margin-bottom: 16px;">
                <span style="font-size: 12px; color: var(--paper-dim);">Total Bobot Komponen:</span>
                <span
                    style="font-family: var(--font-mono); font-size: 13px; font-weight: 700;"
                    :style="totalBobot === 100 ? 'color: var(--status-tuntas);' : 'color: #FF4D4D;'"
                    x-text="totalBobot + '% ' + (totalBobot === 100 ? '(Valid Pas 100%)' : '(Wajib tepat 100%)')"
                ></span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: var(--paper-dim); margin-bottom: 6px;">
                        Default Metode Katrol
                    </label>
                    <select x-model="form.default_metode" class="input-box" style="width: 100%;">
                        <option value="none">Tanpa Katrol (Murni)</option>
                        <option value="tambah">Tambah Tetap (+X)</option>
                        <option value="skalaMax">Skala ke Nilai Maksimum</option>
                        <option value="akar">Akar Kuadrat (sqrt)</option>
                        <option value="minmax">Rentang Min-Max</option>
                    </select>
                </div>

                <div style="display: flex; align-items: center; gap: 10px; margin-top: 24px;">
                    <input
                        type="checkbox"
                        id="default_jangan_turunkan"
                        x-model="form.default_jangan_turunkan"
                        style="width: 16px; height: 16px; accent-color: var(--accent); cursor: pointer;"
                    >
                    <label for="default_jangan_turunkan" style="font-size: 12px; color: var(--paper); cursor: pointer;">
                        Kunci nilai agar tidak pernah turun dari nilai awal
                    </label>
                </div>
            </div>
        </div>

        <!-- TOMBOL SIMPAN & AKSI -->
        <div style="display: flex; gap: 12px; justify-content: flex-end; flex-wrap: wrap;">
            <button
                type="button"
                @click="terapkanKeSimulator()"
                class="btn btn-secondary"
            >
                Terapkan Default ke Simulator
            </button>
            <button
                type="submit"
                class="btn btn-primary"
                :disabled="totalBobot !== 100 || prosesMenyimpan"
            >
                <span x-text="prosesMenyimpan ? 'Menyimpan...' : 'Simpan Profil Guru'"></span>
            </button>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
function profilApp(initialProfil) {
    const defaultData = {
        nama: '',
        nip: '',
        sekolah: '',
        mapel: '',
        kelas: '',
        tahun_ajaran: '2024/2025',
        semester: 'Ganjil',
        default_kkm: 75,
        default_bobot_ph: 40,
        default_bobot_pts: 30,
        default_bobot_pas: 30,
        default_metode: 'none',
        default_jangan_turunkan: true
    };

    return {
        form: Object.assign({}, defaultData, initialProfil || {}),
        prosesMenyimpan: false,
        toast: {
            tampil: false,
            pesan: '',
            sukses: true
        },

        init() {
            // Cek jika ada backup lokal di browser
            try {
                const local = localStorage.getItem('katrollab:profile:v1');
                if (local && (!this.form.nama || this.form.nama.trim() === '')) {
                    const parsed = JSON.parse(local);
                    this.form = Object.assign({}, this.form, parsed);
                }
            } catch (e) {
                console.warn('Gagal membaca localStorage profil', e);
            }
        },

        get inisialGuru() {
            if (!this.form.nama) return 'G';
            const parts = this.form.nama.trim().split(/\s+/);
            if (parts.length >= 2) {
                return (parts[0][0] + parts[1][0]).toUpperCase();
            }
            return (this.form.nama.trim()[0] || 'G').toUpperCase();
        },

        get totalBobot() {
            return (Number(this.form.default_bobot_ph) || 0) +
                   (Number(this.form.default_bobot_pts) || 0) +
                   (Number(this.form.default_bobot_pas) || 0);
        },

        async simpanProfil() {
            if (this.totalBobot !== 100) {
                this.munculkanToast('Total bobot harus tepat 100%!', false);
                return;
            }

            this.prosesMenyimpan = true;
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const resp = await fetch("{{ route('api.profil.simpan', [], false) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                });

                const res = await resp.json();
                if (res.success) {
                    // Simpan juga ke localStorage browser untuk sinkronisasi instan
                    try {
                        localStorage.setItem('katrollab:profile:v1', JSON.stringify(this.form));
                    } catch (e) {}

                    this.munculkanToast('Profil guru berhasil disimpan ke database SQLite!', true);
                } else {
                    this.munculkanToast(res.message || 'Gagal menyimpan profil', false);
                }
            } catch (err) {
                console.error(err);
                this.munculkanToast('Terjadi kendala jaringan saat menyimpan.', false);
            } finally {
                this.prosesMenyimpan = false;
            }
        },

        terapkanKeSimulator() {
            if (this.totalBobot !== 100) {
                this.munculkanToast('Bobot harus 100% sebelum diterapkan!', false);
                return;
            }

            // Simpan profil terlebih dahulu
            this.simpanProfil().then(() => {
                window.location.href = "{{ route('simulator.index') }}";
            });
        },

        munculkanToast(pesan, sukses = true) {
            this.toast.pesan = pesan;
            this.toast.sukses = sukses;
            this.toast.tampil = true;
            setTimeout(() => {
                this.toast.tampil = false;
            }, 3000);
        }
    };
}
</script>
@endpush
