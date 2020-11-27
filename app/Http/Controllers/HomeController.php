<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absensi;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function timeZone($location){
        return date_default_timezone_set($location);
    }
    public function index()
    {
        $this->timeZone('Asia/Jakarta');
        $user_id = Auth::user()->id;
        $date = date("Y-m-d");
        $cek_absensi = Absensi::where(['user_id' => $user_id, 'date' => $date])
                            ->get()
                            ->first();
        if (is_null($cek_absensi)) {
            $info = array(
                "status" => "Anda belum mengisi absensi!",
                "btnIn" => "",
                "btnOut" => "disabled");
        } elseif ($cek_absensi->time_out == NULL) {
            $info = array(
                "status" => "Jangan lupa absen keluar",
                "btnIn" => "disabled",
                "btnOut" => "");
        } else {
            $info = array(
                "status" => "Absensi hari ini telah selesai!",
                "btnIn" => "disabled",
                "btnOut" => "disabled");
        }

        $data_absensi = Absensi::where('user_id', $user_id)
                        ->orderBy('date', 'desc')
                        ->paginate(20);
        return view('home', compact('data_absensi', 'info'));
    }

    public function absensi(Request $request){
        $this->timeZone('Asia/Jakarta');
        $user_id = Auth::user()->id;
        $date = date("Y-m-d"); // 2017-02-01
        $time = date("H:i:s"); // 12:31:20
        $note = $request->note;

        $absensi = new Absensi;
       
        // absen masuk
        if (isset($request->btnIn)) {
             // cek double data
            $cek_double = $absensi->where(['date' => $date, 'user_id' => $user_id])
                                ->count();
            if ($cek_double > 0) {
                return redirect()->back();
            }
            $absensi->create([
                'user_id' => $user_id,
                'date' => $date,
                'time_in' => $time,
                'note' => $note]);
            return redirect()->back();

        }
        // absen keluar
        elseif (isset($request->btnOut)) {
            $absensi->where(['date' => $date, 'user_id' => $user_id])
                ->update([
                    'time_out' => $time,
                    'note' => $note]);
            return redirect()->back();
        }
        return $request->all();
    }

}

