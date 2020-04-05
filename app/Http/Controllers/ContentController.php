<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Article;
use File;

class ContentController extends Controller
{
    public function index()
    {
        $data = Article::all();
        $response['status'] = "sukses";
        $response['data'] = $data;
        return response()->json($response);
    }

    public function byId($id)
    {
        $data = Article::where('id', $id)->get();
        $response['status'] = "sukses";
        $response['data'] = $data;
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:10120',
        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('file');

        $nama_file = time() . "_" . $file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'assets/img';
        $file->move($tujuan_upload, $nama_file);

        $data = Article::create([
            'title' => $request->title,
            'file' => $nama_file,
            'article' => $request->article
        ]);

        $response['status'] = "sukses";
        $response['data'] = $data;
        return response()->json($response);
    }

    public function update($id, Request $request)
    {
        $data = Article::find($id);
        $data->title = $request->title;
        $data->article = $request->article;
        $data->save();

        $response['status'] = "sukses";
        $response['data'] = $data;
        return response()->json($response);
    }

    public function delete($id)
    {
        $data = Article::where('id', $id)->first();
        File::delete('assets/img/' . $data->file);
        $data = Article::where('id', $id)->delete();
        $response['status'] = "sukses";
        $response['data'] = $data;
        return response()->json($response);
    }
}
