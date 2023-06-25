<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //untuk tampilan awal
        //jika request ny ajak maka kode akan dijalankan
        if(request()->ajax()){

            $query = Transaction::query();

            return DataTables::of($query)
            ->addColumn('action',function($item){
                return '
                <a href="'.route("dashboard.transaction.show",$item->id).'" class=" bg-red-500 text-white rounded-md px-2 py-1 m-2">
                Show
                </a>
                <a href="'.route("dashboard.transaction.edit",$item->id).'" class="bg-gray-500 text-white rounded-md px-2 py-1 m-2">
                Edit
                </a>';
             })->rawColumns(['action'])
            ->editColumn('total_price',function($item){
                return number_format($item->total_price);
            })->make();
        }
        return view('pages.dashboard.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        if(request()->ajax()){
            
            //membuat query transactions item dengan product dimana setiap transactions_id harus sama dengan id transaction
            $query = TransactionItem::with(['product'])->where('transactions_id',$transaction->id);

            return DataTables::of($query)
            ->editColumn('product.price',function($item){
                return number_format($item->product->price);
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('pages.dashboard.transaction.show',compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        return view("pages.dashboard.transaction.edit",[
            "item" => $transaction
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request,Transaction $transaction)
    {
        //untuk mengupdate data yang sudah diedit
        //mengambil semua data yang masuk dari request
        $data = $request->all();

        //menambahkan slug secara otmatis sesuai nama

        //untuk menyimpan data
        $transaction->update($data);
 
        return redirect()->route('dashboard.transaction.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
