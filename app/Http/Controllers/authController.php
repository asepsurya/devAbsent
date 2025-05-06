<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\gtk;
use App\Models\User;
use App\Models\student;
use App\Models\Province;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class authController extends Controller
{

    public function loginIndex(){
        return view('authentication.login',[
            'title'=>'Login App'
        ]);
    }
    public function registerIndex(){
        return view('authentication.register',[
            'title'=>'Login App',
            'provinsi'=>Province::all()
        ]);
    }
    public function registerInput(request $request){
        $validator = $request->validate([
            'nis' => 'required|min:9|unique:students',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'gender' => 'required',
            'tanggal_lahir' => 'required',
            'agama' =>'required',
            'alamat' => 'required',
            'id_provinsi' =>'required',
            'id_kota' =>'required',
            'id_kecamatan' =>'required',
            'id_desa' => 'required',
            'email' => 'required|email|unique:users',
            'password'=>'required|same:Cpassword|min:6',
        ]);

        $validator['status'] = '1';
        $validator['tanggal_masuk'] = '';
        $validator['id_rfid']= '';
        $validator ['id_kelas' ]= '';
        $validator['id_rombel']='';
        // validasi chaptcha
        // $request->validate([
        //      'g-recaptcha-response' => 'required|captcha'
        // ]);
        student::create($validator);
        $validatedData = $request->validate([
            'nama'=>'required',
            'email' => 'required|email|unique:users',
            'password'=>'required|same:Cpassword|min:6',

        ]);
         // // enkripsi password
         $validatedData['password'] = Hash::make($validatedData['password'] );
         $validatedData['nama'] = $request->nama;
         $validatedData['nomor'] = $request->nis;
         $validatedData['role'] = '4';
         $validatedData['status'] = '1';

         User::create($validatedData);
         $cekid = User::where('nomor',$request->nis)->get();

            foreach($cekid as $key){
                $getid = $key->id;
                DB::table('model_has_roles')->insert([
                    'role_id' => '3',
                    'model_type'=>'App\Models\User',
                    'model_id'=>$getid
                ]);
            }
         toastr()->success('Pendaftaran Berhasil');
         return redirect()->route('registerinfo');
    }
    public function registerinfo(request $request){
        return view('authentication.info',[
            'title'=>'Terimakasih'
        ]);
    }
    public function registerInputTeacher(request $request){
        $validator = $request->validate([
            'nik' => 'required|min:10|unique:gtks',
            'nip' => '',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'gender' => 'required',
            'tanggal_lahir' => 'required',
            'agama' =>'required',
            'alamat' => 'required',
            'id_provinsi' =>'required',
            'id_kota' =>'required',
            'id_kecamatan' =>'required',
            'id_desa' => 'required',
            'email' => 'required|email|unique:users',
            'password'=>'required|same:Cpassword|min:6',
            'telp'=>'required',
        ]);
        // validasi chaptcha
        $request->validate([
             'g-recaptcha-response' => 'required|captcha'
        ]);
        $validator['status'] = '1';
        $validator['tanggal_masuk'] = '';
        $validator['id_rfid']= '';
        $validator['id_jenis_gtk']='3';

        gtk::create($validator);
        $validatedData = $request->validate([
            'nama'=>'required',
            'email' => 'required|email|unique:users',
            'password'=>'required|same:Cpassword|min:6',

        ]);
         // // enkripsi password
         $validatedData['password'] = Hash::make($validatedData['password'] );
         $validatedData['nama'] = $request->nama;
         $validatedData['nomor'] = $request->nik;
         $validatedData['role'] = '3';
         $validatedData['status'] = '1';

         User::create($validatedData);
         $cekid = User::where('nomor',$request->nik)->get();
        foreach($cekid as $key){
            $getid = $key->id;
            foreach($cekid as $key){
                $getid = $key->id;
                DB::table('model_has_roles')->insert([
                    'role_id' => '2',
                    'model_type'=>'App\Models\User',
                    'model_id'=>$getid
                ]);
            }
        }
         toastr()->success('Pendaftaran Berhasil');
         return redirect()->route('registerinfo');

    }

    // login Action
    public function loginAction(request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        // cari user berdasarkan email atau nomor
        $user = \App\Models\User::where(function($query) use ($request) {
                $query->where('email', $request->email)
                      ->orWhere('nomor', $request->email);
            })
            ->where('status', '2') // misal status aktif
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            toastr()->success('Login Berhasil');

            // redirect sesuai role
            switch (Auth()->user()->role) {
                case 'admin':
                    return redirect()->intended(route('dashboard.admin'));
                case 'superadmin':
                    return redirect()->intended(route('dashboard.superadmin'));
                case 'walikelas':
                    return redirect()->intended(route('dashboard.walikelas'));
                case 'guru':
                    return redirect()->intended(route('dashboard.teacher'));
                case 'siswa':
                    return redirect()->intended(route('dashboard.student'));
                default:
                    return redirect('/');
            }
        } else {
            toastr()->error('Login Gagal! Cek email/nomor dan password kamu.');
            return back()->with('loginError', 'Login Gagal! Cek email/nomor dan password kamu.');
        }

    }

    public function profileIndex($id){
        return view('setelan.profile',[
            'title'=>'Profil Saya',
            'user'=>User::where('nomor',$id)->get(),
            'provinsi'=>Province::all()
        ]);
    }
    public function profileUpdate(request $request){
        if(auth()->user()->role == "siswa"){
            student::where('nis',$request->id)->update([
                "alamat" => $request->alamat,
                "id_provinsi" => $request->id_provinsi,
                "id_kota" => $request->id_kota,
                "id_kecamatan" => $request->id_kecamatan,
                "id_desa" => $request->id_desa
            ]);
        }else{
            gtk::where('nik',$request->id)->update([
                "alamat" => $request->alamat,
                "id_provinsi" => $request->id_provinsi,
                "id_kota" => $request->id_kota,
                "id_kecamatan" => $request->id_kecamatan,
                "id_desa" => $request->id_desa
            ]);
        }
        toastr()->success('Data berhasil diupdate');
        return redirect()->back();
    }
    public function imageProfile(request $request){


            if(auth()->user()->gtk){
                $base64Image=  $request->input('gambar');
            }else{
                $base64Image =$request->input('foto');
            }

            // Decode the image
            $imageParts = explode(';base64,', $base64Image);
            $imageType = explode('image/', $imageParts[0])[1]; // e.g., jpeg, png

            // Validate image type
            $allowedTypes = ['jpeg', 'png', 'jpg', 'gif'];
            if (!in_array($imageType, $allowedTypes)) {
                toastr()->error('Invalid image type.');
                return redirect()->back();
            }

            // Decode the Base64 image
            $imageBase64 = base64_decode($imageParts[1]);

            // Generate unique file name
            $fileName = 'FotoProfile/' . uniqid() . '.' . $imageType;

            // Save image to storage
            Storage::put($fileName, $imageBase64);

            // Delete old image if it exists
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }

            // Update the database with the new file path
            if (auth()->user()->gtk) {
                gtk::where('nik', $request->id)->update(['gambar' => $fileName]);
            } else {
                student::where('nis', $request->id)->update(['foto' => $fileName]);
            }

            toastr()->success('Profile photo updated successfully.');
            return redirect()->back();


    }
    // logout action
    Public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function role(request $request){
        return view('sample');
        // if($request->user()->hasRole('siswa')){
        //     return 'role';
        // }
        // abort(403);
    }

    public function lupapassword(){
        return view('authentication.lupapass',[
            'title'=>'Lupa Password'
        ]);
    }

    public function generate()
    {
        // Ambil data provinsi, cache selama 1 jam
        $provinsi = Cache::remember('daftar_provinsi', 60*60, function () {
            $response = Http::get('https://ibnux.github.io/data-indonesia/provinsi.json');
            return $response->successful() ? $response->json() : [];
        });

        // Pastikan data provinsi valid (bukan null atau kosong)
        if (empty($provinsi)) {
            return response('Tidak dapat mengambil data provinsi.', 500);
        }

        // Ambil provinsi random
        $randomProvinsi = $provinsi[array_rand($provinsi)];
        $text = $randomProvinsi['nama'];

        // Simpan ke session untuk verifikasi nanti
        Session::put('captcha_provinsi', $text);
        \Log::info('Captcha Provinsi: ' . Session::get('captcha_provinsi'));

        // Path font (pastikan font tersebut ada)
        $fontPath = public_path('fonts/font.otf');  // Ganti dengan font yang sesuai

        if (!file_exists($fontPath)) {
            return response('Font file not found.', 500);
        }

        // Ukuran font yang digunakan
        $fontSize = 20;

        // Hitung bounding box untuk teks (ukuran lebar dan tinggi)
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);

        // Hitung lebar dan tinggi teks
        $textWidth = $bbox[2] - $bbox[0];  // Lebar teks (koordinat kanan - kiri)
        $textHeight = $bbox[1] - $bbox[7]; // Tinggi teks (koordinat atas - bawah)

        // Tentukan ukuran gambar berdasarkan lebar teks
        $imageWidth = $textWidth + 20;  // Menambahkan margin agar tidak terlalu rapat
        $imageHeight = $textHeight + 20; // Menambahkan margin

        // Buat gambar dengan ukuran dinamis
        $image = imagecreate($imageWidth, $imageHeight);

        // Warna latar belakang dan teks
        $bgColor = imagecolorallocate($image, 255, 255, 255);  // Putih
        $textColor = imagecolorallocate($image, 255, 105, 180); // pink soft    // Hitam

        // Posisi teks agar berada di tengah
        $x = (imagesx($image) - $textWidth) / 2;  // Menempatkan teks di tengah secara horizontal
        $y = (imagesy($image) + $textHeight) / 2; // Menempatkan teks di tengah secara vertikal

        // Tulis teks di gambar
        imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontPath, $text);

        // Output sebagai image PNG
        ob_start();
        imagepng($image);
        $imgData = ob_get_clean();
        imagedestroy($image);

        return response($imgData)->header('Content-Type', 'image/png');
    }


    public function submit(Request $request)
    {

        $custom =[
            'email.required'=>'Email tidak boleh Kosong',
            'email.email'=>'Email tidak valid',
            'email.exists'=>'Email tidak terdaftar di sistem kami'
        ];
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'captcha_input' => 'required'
        ],$custom);

        if ($request->captcha_input != session('captcha_provinsi')) {
            return back()->with('error', 'Kode captcha tidak cocok.');
        }

        $token = Str::random(60);
        PasswordResetToken::updateOrCreate(
            ['email' => $request->email], // kondisi pencarian
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token));
        // Validasi dan proses reset password
        $user = User::where('email',$request->email)->first(); // Ambil user berdasarkan ID
        return back()->with('success', 'Password reset telah dikirim ke email anda.');
    }


    public function showResetForm($token){
        $email = PasswordResetToken::where('token',$token)->first();
        if (!$email) {
            return redirect('/login')->with('error', 'Link reset password sudah kadaluarsa');
        }

        return view('authentication.reset-password',[
            'token' =>$token,
            'email'=>$email
        ]);
    }


    public function resetPassword(request $request){

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|same:password_confirm',
            'password_confirm' => 'required|same:password'
        ]);

        $request->validate([
            'g-recaptcha-response' => 'required|captcha'
       ]);

       $user = User::where('email', $request->email)->update([
        'password' => Hash::make($request->password_confirm)
        ]);

        PasswordResetToken::where('email',$request->email)->delete();

        if($user){
            return redirect('/login')->with('success', 'Password berhasil di-reset. Silakan login dengan password baru kamu.');
        }else{
            return back()->with('error', 'Reset password gagal.');
        }

    }
}
