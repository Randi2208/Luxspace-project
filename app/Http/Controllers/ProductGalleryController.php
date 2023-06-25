<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGalleryRequest;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        //untuk tampilan awal
        //jika request ny ajak maka kode akan dijalankan
        if(request()->ajax()){

            //query adalah function untuk memanipulasi table
            $query = ProductGallery::with(['product'])->where('products_id',$product->id);

            return DataTables::of($query)
            ->addColumn('action',function($item){
                //tombol Hapus berguna untuk mengarahkan ke function destroy
                return '
                <form class="inline-block" action="'.route('dashboard.gallery.destroy',$item->id).'" method="POST">
                    <button class="bg-red-500 text-white rounded-md px-2 py-1 m-2">
                        Hapus
                    </button> 
                    '.method_field('delete').csrf_field() .'  
                    </form>
                '; 
            })->rawColumns(['action','url'])
            //menampilkan gambar
            ->editColumn('url',function($item){
                return '<img style="max-width : 150px" src="'.Storage::url($item->url).'"/>';
            })
            //menampilkan apakah featured atau bukan
            ->editColumn('is_featured',function($item){
                return $item->is_featured? 'Yes': 'No';
            })
            ->make(); 
           }
           //mengembalikan view ditambah menambahkan data product
           return view('pages.dashboard.gallery.index',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view('pages.dashboard.gallery.create',compact('product'));
    }

       

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductGalleryRequest $request,Product $product)
    {
        //mengambil data di fild files
        $files = $request->file('files');

        //jika gambarnya ada
        if($request->hasFile('files')){
            //pengulangan untuk menyimpan gambar satu satu
            foreach($files as $file){
                //menyimpan url nya ke dalam variable path
                $path = $file->store('public/gallery');

                //menyimpan gambar nya dengan products id
                ProductGallery::create([
                    'products_id' => $product->id,
                    'url' => $path
                ]);
            }
        }
        return redirect()->route('dashboard.product.gallery.index',$product->id);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('dashboard.product.gallery.index',$gallery->products_id);

    }
}
