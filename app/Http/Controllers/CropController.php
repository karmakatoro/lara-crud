<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CropController extends Controller
{
    public function index()
    {
        return view('crop.img-crop');
    }
    public function crop_img(){
        $data = $_POST['imge'];
        $image_array_1 = explode(",", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $image_name = 'upload/' . time() . '.png';
        file_put_contents($image_name, $data);
        echo $image_name;
    }
}
