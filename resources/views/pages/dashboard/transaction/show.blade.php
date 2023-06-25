<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(Route::currentRouteName() == 'dashboard.transaction.show')
            <a href="{{route('dashboard.transaction.index')}}">Transaction </a>
            &raquo; # {{$transaction->id}} {{$transaction->name}}
            @elseif(Route::currentRouteName() == 'dashboard.my-transaction.show')
            <a href="{{route('dashboard.my-transaction.index')}}">My Transaction </a>
            &raquo; # {{$transaction->id}} {{$transaction->name}}
            @endif     
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            //Ajax datatable untuk settingan table nya
            var datatable = $('#crudTable').DataTable({
                //menambahkan data ajax dengan url yang sekarang
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columns: [
                    //menentukan data apa saja yang ingin ditampilkan
                    { data: 'id', name: 'id', width: '5%' },
                    { data: 'product.name', name: 'product.name' },                    
                    { data: 'product.price', name: 'product.price' },
                ]
            });
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{--membuat tabel detail--}}
            <h2 class="font-semi-bold text-lg text-gray-800 leading-tight mb-5">
                Transaction Details
            </h2>
            <div class="p-6 bg-white border-b border-gray-200">
                <table class="table-auto w-ful">
                    <tbody>
                        <tr>
                            <th class="border px-6 py-4 text-right">Name</th>
                            <td class="border px-6 py-4">{{ $transaction->name }}</td>
                        </tr>
                        <tr>
                            <th class="border px-6 py-4 text-right">Email</th>
                            <td class="border px-6 py-4">{{ $transaction->email }}</td>
                        </tr>
                        <tr>
                            <th class="border px-6 py-4 text-right">Address</th>
                            <td class="border px-6 py-4">{{ $transaction->address }}</td>
                        </tr>
                        <tr>
                            <th class="border px-6 py-4 text-right">Phone</th>
                            <td class="border px-6 py-4">{{ $transaction->phone }}</td>
                        </tr>
                        <tr>
                            <th class="border px-6 py-4 text-right">Courier</th>
                            <td class="border px-6 py-4">{{ $transaction->courier }}</td>
                        </tr>
                        <tr>
                            <th class="border px-6 py-4 text-right">Payment</th>
                            <td class="border px-6 py-4">{{ $transaction->payment }}</th>
                        </tr>
                        <tr>
                            <th class="border px-6 py-4 text-right">Payment Url</th>
                            <td class="border px-6 py-4">{{ $transaction->payment_url }}</td>
                        </tr>
                        <tr>
                            <th class="border px-6 py-4 text-right">Total Price</th>
                            <td class="border px-6 py-4">{{ number_format($transaction->total_price) }}</td>
                        </tr>
                        <tr>
                            <th class="border px-6 py-4 text-right">Status</th>
                            <td class="border px-6 py-4">{{ $transaction->status }}</td>
                        </tr>
                    </tbody>
                    
                </table>
            </div>

            <h2 class="font-semi-bold text-lg text-gray-800 leading-tight mb-5">
                Transaction Item
            </h2>
                {{--menambah tabel--}}
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Harga</th>
                            </tr>    
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
