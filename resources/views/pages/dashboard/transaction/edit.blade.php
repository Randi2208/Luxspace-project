<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{--menampilkan nama product yang akan diedit--}}
            <a href="{{route('dashboard.transaction.index')}}">Transaction </a>
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
                <form action="{{ route('dashboard.transaction.update',$item->id)}}" class="w-full" method="post" enctype="multipart/form-data">
                    @csrf
                    {{--menambah method put untuk updatenya--}}
                    @method('PUT')
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3" >
                            {{--  value="{{old('name') ?? $item->name}}" memiliki maksud jika ada old name nya maka yang dipakai old name jika tidak maka akan mengambil $item->name--}}
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Status</label>
                            <select name="status"  class="block w-full bg-gray200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:g-whitw focus:border-gray-500">
                                <option value="{{ $item->status }}">{{ $item->status }}</option>
                                <option disabled>----------</option>
                                <option value="PENDING">PENDING</option>
                                <option value="SUCCESS">SUCCESS</option>
                                <option value="CHALLENGE">CHALLENGE</option>
                                <option value="FAILED">FAILED</option>
                                <option value="SHIPPING">SHIPPING</option>
                                <option value="SHIPPED">SHIPPED</option>
                            </select>
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
        </div>
    </div>
</x-app-layout>
