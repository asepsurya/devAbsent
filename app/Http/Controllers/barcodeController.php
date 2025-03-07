<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class barcodeController extends Controller
{
    public function generateQRCode($code)
    {
        // Generate QR code image
        $qrCodeImage = QrCode::format('png')->size(250)->generate($code);

        // Define the file path where the QR code will be saved
        $filePath = public_path("qrcodes/{$code}.png");

        // Ensure the directory exists
        if (!file_exists(public_path("qrcodes"))) {
            mkdir(public_path("qrcodes"), 0777, true);
        }

        // Save the QR code image to the file path
        file_put_contents($filePath, $qrCodeImage);

        // Return the path of the saved QR code image
        return response()->json(['url' => url('qrcodes/' . $code . '.png')]);
    }
    public function card(){
        return view('akdemik.datainduk.card.gtkCard');
    }


}
