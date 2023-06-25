<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //untuk tampilan awal
        //jika request ny ajak maka kode akan dijalankan
        if(request()->ajax()){

            $query = Product::query();

            return DataTables::of($query)
            ->addColumn('action',function($item){
                return '
                <a href="'.route("dashboard.product.gallery.index",$item->id).'" class=" bg-red-500 text-white rounded-md px-2 py-1 m-2">
                Gallery
                </a>
                <a href="'.route("dashboard.product.edit",$item->id).'" class="bg-gray-500 text-white rounded-md px-2 py-1 m-2">
                Edit
                </a>
                <form class="inline-block" action="'.route('dashboard.product.destroy',$item->id).'" method="POST">
                    <button class="bg-red-500 text-white rounded-md px-2 py-1 m-2">
                        Hapus
                    </button> 
                    '.method_field('delete').csrf_field() .'  
                    </form>
                '; //tombol Hapus berguna untuk mengarahkan ke function destroy dan edit ke function edit
            })->rawColumns(['action'])
            ->editColumn('price',function($item){
                return number_format($item->price);
            })->make();
        }
        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //untuk tampilan create
        return view('pages.dashboard.product.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        
        //mengambil semua data yang masuk dari request
        $data = $request->all();

        //menambahkan slug secara otmatis sesuai nama
        $data['slug'] = Str::slug($request->name);

        //untuk menyimpan data
        Product::create($data);
 
        return redirect()->route('dashboard.product.index');
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
    public function edit(Product $product)
    {
        //mereturnkan view edit dengan data product diwakilkan oleh variable item
        return view('pages.dashboard.product.edit',[
            'item'=>$product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        //untuk mengupdate data yang sudah diedit
        //mengambil semua data yang masuk dari request
        $data = $request->all();

        //menambahkan slug secara otmatis sesuai nama
        $data['slug'] = Str::slug($request->name);

        //untuk menyimpan data
        $product->update($data);
 
        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard.product.index');
    }
}
