<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{--menampilkan nama product yang akan diedit--}}
            <a href="{{route('dashboard.product.index')}}">Product </a>
            &raquo; {{$item->name}}  &raquo; Edit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div>
            <div>
                @if ($errors->any())
                    <div class="mb-5" role="alert">
                        {{--membuat notifikasi error--}}
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            There's something wrong!
                        </div>
                        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3">
                            <p>
                                <ul>
                                    {{--menampilkan apa yang eror--}}
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </p>
                        </div>
                    </div>
                @endif
                {{--mengarahkan kebagian update--}}
                <form action="{{ route('dashboard.product.update',$item->id)}}" class="w-full" method="post" enctype="multipart/form-data">
                    @csrf
                    {{--menambah method put untuk updatenya--}}
                    @method('PUT')
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3" >
                            {{--  value="{{old('name') ?? $item->name}}" memiliki maksud jika ada old name nya maka yang dipakai old name jika tidak maka akan mengambil $item->name--}}
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Name</label>
                            <input type="text" value="{{old('name') ?? $item->name}}" name="name" placeholder="Product Name" class="block w-full bg-gray200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:g-whitw focus:border-gray-500">
                        </div>
                    </div>
    
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Description</label>
                            <textarea type="text"  name="description"  class="block w-full bg-gray200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:g-whitw focus:border-gray-500">{!! old('description') ?? $item->description !!}</textarea>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Price</label>
                            <input type="number" value="{{old('price') ?? $item->price}}" name="price" placeholder="Product Price" class="block w-full bg-gray200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:g-whitw focus:border-gray-500">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                Save Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
            <script>
                CKEDITOR.replace( 'description' );
            </script>
        </div>
        </div>
    </div>
</x-app-layout>
