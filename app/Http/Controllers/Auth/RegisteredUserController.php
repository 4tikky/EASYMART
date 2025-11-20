<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman form registrasi penjual.
     */
    public function create(): View
    {
        // ini yang dipakai oleh route GET /register
        return view('auth.register');
    }

    /**
     * Handle request registrasi penjual.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Data PIC + login
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_handphone_pic' => ['required', 'string', 'max:20'],

            // Data toko
            'nama_toko'         => ['required', 'string', 'max:255'],
            'deskripsi_singkat' => ['nullable', 'string'],

            // Alamat
            'alamat_pic'     => ['required', 'string', 'max:255'],
            'rt'             => ['required', 'string', 'max:5'],
            'rw'             => ['required', 'string', 'max:5'],
            'nama_kelurahan' => ['required', 'string', 'max:100'],
            'kabupaten_kota' => ['required', 'string', 'max:100'],
            'provinsi'       => ['required', 'string', 'max:100'],

            // Dokumen identitas
            'no_ktp_pic'          => ['required', 'string', 'max:50'],
            'foto_pic'            => ['nullable', 'image', 'max:2048'],
            'file_upload_ktp_pic' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $fotoPath = $request->file('foto_pic')
            ? $request->file('foto_pic')->store('foto_pic', 'public')
            : null;

        $ktpPath = $request->file('file_upload_ktp_pic')
            ? $request->file('file_upload_ktp_pic')->store('ktp_pic', 'public')
            : null;

        // sementara masih simpan di tabel users seperti sebelumnya
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),

            // role & status verifikasi
            'role'              => 'penjual',
            'status_verifikasi' => 'pending',

            // (kalau kamu masih punya kolom-kolom tambahan di users)
            'nama_toko'         => $validated['nama_toko'],
            'deskripsi_singkat' => $validated['deskripsi_singkat'] ?? null,
            'no_handphone_pic'  => $validated['no_handphone_pic'],
            'alamat_pic'        => $validated['alamat_pic'],
            'rt'                => $validated['rt'],
            'rw'                => $validated['rw'],
            'nama_kelurahan'    => $validated['nama_kelurahan'],
            'kabupaten_kota'    => $validated['kabupaten_kota'],
            'propinsi'          => $validated['provinsi'],
            'no_ktp_pic'        => $validated['no_ktp_pic'],
            'foto_pic'          => $fotoPath,
            'file_upload_ktp_pic' => $ktpPath,
        ]);

        event(new Registered($user));

        // JANGAN auto-login, karena harus menunggu verifikasi
        // Auth::login($user);

        return redirect()
            ->route('seller.register.waiting')
            ->with('status', 'Registrasi berhasil. Akun Anda akan diperiksa admin terlebih dahulu.');
    }
}
