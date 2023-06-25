<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
                //untuk tampilan awal
        //jika request ny ajak maka kode akan dijalankan
        if(request()->ajax()){

            $query = User::query();

            return DataTables::of($query)
            ->addColumn('action',function($item){
                return '
                <a href="'.route("dashboard.user.edit",$item->id).'" class="bg-gray-500 text-white rounded-md px-2 py-1 m-2">
                Edit
                </a>
                <form class="inline-block" action="'.route('dashboard.user.destroy',$item->id).'" method="POST">
                    <button class="bg-red-500 text-white rounded-md px-2 py-1 m-2">
                        Hapus
                    </button> 
                    '.method_field('delete').csrf_field() .'  
                    </form>
                '; //tombol Hapus berguna untuk mengarahkan ke function destroy dan edit ke function edit
            })->rawColumns(['action'])->make();
        }
        return view('pages.dashboard.user.index');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pages.dashboard.user.edit',[
            'item'=> $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
          //untuk mengupdate data yang sudah diedit
        //mengambil semua data yang masuk dari request
        $data = $request->all();

        //menambahkan slug secara otmatis sesuai nama

        //untuk menyimpan data
        $user->update($data);
 
        return redirect()->route('dashboard.user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('dashboard.user.index');
    }
}
