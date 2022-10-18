<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    //
    public function index()
    {
        return view('qrcode');
    }

    public function saveToStorage()
    {

        $ext = ".png";
        $filename = rand() . "_" . time() . $ext;
        $content = "A simple example of QR code!";

        // $path = storage_path("app/pubilc/qrcodes");

        if (!extension_loaded('imagick')) return dd('imagick not installed');

        try {
            $image = QrCode::format('png')
                // ->merge('img/t.jpg', 0.1, true) // รูปที่อยู่ตรงกลาง
                ->size(250)
                ->errorCorrection('H')
                ->generate($content);

            $output_file = "/qrcodes/{$filename}";

            $qrCode = Storage::disk('pubilc')->put($output_file, $image); //storage/app/public/img/qr-code/img-1557309130.png

            // $fullpath = "{$path}/{$filename}{$ext}";
            // // dd($fullpath);
            // $qrCode = QrCode::format('png')->size(250)->generate('Make me a QrCode!');
            // // ->mergeString(Storage::get('path/to/image.png'))

            // // QrCode::generate('Make me into a QrCode!', $fullpath)->format('png');
            dd('ok', $qrCode);
        } catch (\Throwable $th) {
            //throw $th;

            dd('fail', $th);
        }
    }
}
