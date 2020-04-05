<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Gallery;
use App\Model\Photos;
use File;


class GalleryController extends Controller
{
    public function index($page, $limmit)
    {
        // $pages = * 5;
        $relation = DB::table('gallery')->join('photos', 'photos.id_gallery', '=', 'gallery.id')->OFFSET($page)->take($limmit)->get();
        //dd($relation);
        if (count($relation) >= 1) {
            $response['status'] = "sukses";
            $response['data'] = $relation;
            return response()->json($response);
        } else {
            $response['status'] = "sukses";
            $response['data'] = "empty";
            return response()->json($response);
        }
    }

    public function byId($id)
    {
        $relation = DB::table('gallery')->join('photos', 'photos.id_gallery', '=', 'gallery.id')->where('id_gallery', $id)->get();
        $datas = count($relation);
        if ($datas > 0) {
            $response['status'] = "sukses";
            $response['data'] = $relation;
            return response()->json($response);
        } else {
            $response['status'] = "sukses";
            $response['data'] = "empty";
            return response()->json($response);
        }
    }

    public function store(Request $request)
    {
        $dataP = Gallery::create(['information' => $request->information]);
        $parrent = DB::table('gallery')->max('id');
        //dd($parrent);
        $datas = [];
        $file = $request->file('photos');
        $tujuan_upload = 'assets/gallery';
        foreach ($file as $fl) {
            $nama_file = time() . "_" . $fl->getClientOriginalName();
            $fl->move($tujuan_upload, $nama_file);
            $datas[] = ['id_gallery' => $parrent, 'photos' => $nama_file];
        }
        //dd($datas);
        $data = DB::table('photos')->insert($datas);
        $response['status'] = "sukses";
        $response['Parrent'] = $dataP;
        $response['data'] = $data;
        return response()->json($response);
    }

    public function update($id, Request $request)
    {
        $data = Gallery::find($id);
        $data->information = $request->information;
        $data->save();

        $response['status'] = "sukses";
        $response['data'] = $data;
        return response()->json($response);
    }

    public function delete($id)
    {
        $data = Photos::Where('id_gallery', $id)->first();
        File::delete('assets/gallery/' . $data->photos);

        $dataP = Gallery::where('id', $id)->delete();
        $data = Photos::Where('id_gallery', $id)->delete();

        $response['status'] = "sukses";
        $response['parent'] = $dataP;
        $response['child'] = $data;
        return response()->json($response);
    }
}
