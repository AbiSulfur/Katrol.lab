@extends('layouts.app')

@section('title', 'Profil Guru - Katrol.Lab')

@section('header_actions')
    <a href="{{ route('simulator.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-[#1a1a1a] text-[#F0EDE7] border border-[#303030] font-sans text-xs font-semibold hover:bg-[#242424] transition-colors">
        Kembali ke Simulator
    </a>
@endsection

@section('content')
<div x-data="profilApp(@js($profil))" x-init="init()" class="h-full overflow-y-auto px-4 sm:px-6 py-10 max-w-4xl mx-auto w-full">

    <!-- TOAST NOTIFIKASI -->
    <div
        x-show="toast.tampil"
        x-transition:enter="transition duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed bottom-6 right-6 z-50 px-5 py-3 rounded border font-sans text-xs font-semibold shadow-2xl flex items-center gap-2"
        :class="toast.sukses ? 'bg-[#1a1a1a] text-[#4BFFA0] border-[#4BFFA0]/30' : 'bg-[#1a1a1a] text-[#FF3366] border-[#FF3366]/30'"
        style="display:none;"
    >
        <span class="w-2 h-2 rounded-full bg-current shrink-0"></span>
        <span x-text="toast.pesan"></span>
    </div>

    <!-- HEADER PROFIL GURU -->
    <div class="bg-[#111111] border border-[#242424] rounded p-6 mb-6 flex items-center gap-5">
        <div class="w-16 h-16 rounded-full bg-[#FF4D00] text-[#080808] font-display text-2xl font-extrabold flex items-center justify-center shrink-0 shadow-lg shadow-[#FF4D00]/20">
            <span x-text="inisialGuru"></span>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="font-display text-xl sm:text-2xl font-extrabold text-[#F0EDE7] leading-tight" x-text="form.nama || 'Nama Guru Belum Diisi'"></h1>
            <div class="text-xs sm:text-sm text-[#A8A39A] mt-1 flex items-center gap-2.5 flex-wrap">
                <span x-text="form.mapel ? 'Mapel: ' + form.mapel : 'Mata Pelajaran Belum Diatur'"></span>
                <span class="text-[#585450]">&bull;</span>
                <span x-text="form.sekolah ? form.sekolah : 'Sekolah Belum Diatur'"></span>
            </div>
        </div>
    </div>

    <form @submit.prevent="simpanProfil()">

        <!-- PANEL 1: IDENTITAS GURU & KELAS -->
        <div class="bg-[#111111] border border-[#242424] rounded p-6 mb-5">
            <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#FF4D00] mb-4">Panel A: Identitas Guru & Kelas</div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        Nama Lengkap Guru <span class="text-[#FF4D00]">*</span>
                    </label>
                    <input
                        type="text"
                        x-model="form.nama"
                        placeholder="Contoh: Drs. Bambang Sutrisno, M.Pd."
                        class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors"
                        required
                        maxlength="100"
                    >
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        NIP / NUPTK (Opsional)
                    </label>
                    <input
                        type="text"
                        x-model="form.nip"
                        placeholder="Contoh: 19820415 200801 1 007"
                        class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors"
                        maxlength="50"
                    >
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        Asal Satuan Pendidikan / Sekolah
                    </label>
                    <input
                        type="text"
                        x-model="form.sekolah"
                        placeholder="Contoh: SMAN 1 Indonesia Maju"
                        class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors"
                        maxlength="150"
                    >
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        Mata Pelajaran yang Diampu
                    </label>
                    <input
                        type="text"
                        x-model="form.mapel"
                        placeholder="Contoh: Matematika Wajib"
                        class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors"
                        maxlength="100"
                    >
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        Rombongan Belajar / Kelas
                    </label>
                    <input
                        type="text"
                        x-model="form.kelas"
                        placeholder="Contoh: XII MIPA 2"
                        class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors"
                        maxlength="50"
                    >
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        Tahun Ajaran (Format: YYYY/YYYY)
                    </label>
                    <input
                        type="text"
                        x-model="form.tahun_ajaran"
                        placeholder="2024/2025"
                        class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors"
                        pattern="^\d{4}/\d{4}$"
                        title="Gunakan format 4 digit garis miring 4 digit (misal: 2024/2025)"
                        maxlength="20"
                    >
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        Semester
                    </label>
                    <select x-model="form.semester" class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors">
                        <option value="Ganjil">Semester Ganjil</option>
                        <option value="Genap">Semester Genap</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- PANEL 2: PREFERENSI DEFAULT SIMULATOR -->
        <div class="bg-[#111111] border border-[#242424] rounded p-6 mb-6">
            <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#FF4D00] mb-4">Panel B: Standar Default Simulator</div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 mb-5">
                <div>
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        Default KKM
                    </label>
                    <input
                        type="number"
                        x-model.number="form.default_kkm"
                        min="0"
                        max="100"
                        class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors"
                        required
                    >
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        Bobot PH (%)
                    </label>
                    <input
                        type="number"
                        x-model.number="form.default_bobot_ph"
                        min="0"
                        max="100"
                        class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors"
                        required
                    >
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        Bobot PTS (%)
                    </label>
                    <input
                        type="number"
                        x-model.number="form.default_bobot_pts"
                        min="0"
                        max="100"
                        class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors"
                        required
                    >
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        Bobot PAS (%)
                    </label>
                    <input
                        type="number"
                        x-model.number="form.default_bobot_pas"
                        min="0"
                        max="100"
                        class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors"
                        required
                    >
                </div>
            </div>

            <!-- Indikator Total Bobot -->
            <div class="flex items-center justify-between p-3 bg-[#1a1a1a] border border-[#242424] rounded mb-5">
                <span class="text-xs text-[#A8A39A]">Total Bobot Komponen:</span>
                <span
                    class="font-mono text-xs font-bold"
                    :class="totalBobot === 100 ? 'text-[#4BFFA0]' : 'text-[#FF4D4D]'"
                    x-text="totalBobot + '% ' + (totalBobot === 100 ? '(Valid Pas 100%)' : '(Wajib tepat 100%)')"
                ></span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-semibold text-[#A8A39A] mb-1.5">
                        Default Metode Katrol
                    </label>
                    <select x-model="form.default_metode" class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-2 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors">
                        <option value="none">Tanpa Katrol (Murni)</option>
                        <option value="tambah">Tambah Tetap (+X)</option>
                        <option value="skalaMax">Skala ke Nilai Maksimum</option>
                        <option value="akar">Akar Kuadrat (sqrt)</option>
                        <option value="minmax">Rentang Min-Max</option>
                    </select>
                </div>

                <div class="flex items-center gap-2.5 sm:pt-6">
                    <input
                        type="checkbox"
                        id="default_jangan_turunkan"
                        x-model="form.default_jangan_turunkan"
                        class="w-4 h-4 accent-[#FF4D00] rounded cursor-pointer"
                    >
                    <label for="default_jangan_turunkan" class="text-xs text-[#F0EDE7] cursor-pointer">
                        Kunci nilai agar tidak pernah turun dari nilai awal
                    </label>
                </div>
            </div>
        </div>

        <!-- TOMBOL SIMPAN & AKSI -->
        <div class="flex items-center justify-end gap-3 flex-wrap">
            <button
                type="button"
                @click="terapkanKeSimulator()"
                class="px-4 py-2 rounded bg-[#1a1a1a] text-[#F0EDE7] border border-[#303030] font-sans text-xs font-semibold hover:bg-[#242424] transition-colors cursor-pointer"
            >
                Terapkan Default ke Simulator
            </button>
            <button
                type="submit"
                class="px-5 py-2 rounded bg-[#FF4D00] text-[#080808] font-sans text-xs font-bold hover:bg-[#FF6020] transition-colors disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer shadow-lg shadow-[#FF4D00]/20"
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
