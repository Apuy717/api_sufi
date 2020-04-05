<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Sound;
use File;

class LayangSworo extends Controller
{
    public function index()
    {
        $data = Sound::all();
        if (count($data) > 0) {
            $response['status'] = "sukses";
            $response['data'] = $data;
            return response()->json($response);
        } else {
            $response['status'] = "sukses";
            $response['data'] = "empty";
            return response()->json($response);
        }
    }

    public function byId($id)
    {
        $data = Sound::find($id);
        $response['status'] = "sukses";
        $response['data'] = $data;
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $photos = $request->file('photos');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $nama_photos = time() . "_" . $photos->getClientOriginalName();
        $tujuan_upload = 'assets/sound';
        $path = 'assets/sound/img';
        $file->move($tujuan_upload, $nama_file);
        $photos->move($path, $nama_photos);

        $data = Sound::create(['title' => $request->title, 'photos' => $nama_photos, 'file' => $nama_file]);
        $response['status'] = "sukses";
        $response['data'] = $data;
        return response()->json($response);
    }

    public function update($id, Request $request)
    {
        $data = Sound::find($id);
        $data->title = $request->title;
        $data->save();
        $response['status'] = "sukses";
        $response['data'] = $data;
        return response()->json($response);
    }

    public function delete($id)
    {
        $data_files = Sound::where('id', $id)->first();
        File::delete('assets/sound/img/' . $data_files->photos);
        File::delete('assets/sound/' . $data_files->file);

        $data = Sound::where('id', $id)->delete();
        $response['status'] = "sukses";
        $response['data'] = $data;
        return response()->json($response);
    }
}
