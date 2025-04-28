@extends('mahasiswa.layouts.app')

@section('content')
    <div class="bg-white min-h-screen flex justify-center items-center pb-20">
        <div class="bg-white p-6 rounded-lg flex flex-col md:flex-row w-full max-w-7xl">
            <div class="flex flex-col w-full md:w-1/2">

                <img id="mainImage" src="{{ $ruangan->gambar }}" alt="{{ $ruangan->nama_ruangan }}" class="w-full h-[500px] rounded-xl shadow-xl object-cover mb-4" />
            </div>
            <div class="w-full md:w-1/2 bg-white text-red-700 rounded-lg p-6 ml-0 md:ml-8">
                <p class="mt-2 font-semibold text-red-500 mb-3">{{ $ruangan->lokasi }}</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ $ruangan->nama_ruangan }}</h3>
                <p class="mt-2 font-semibold">Fasilitas:</p>
                <p class="mt-2 text-lg leading-8 text-gray-600 mb-5">{{ $ruangan->fasilitas }}</p>
                <p class="mt-2 font-semibold">Kapasitas:</p>
                <p class="mt-2 text-lg leading-8 text-gray-600 mb-5">{{ $ruangan->kapasitas }} orang</p>
                <p class="mt-2 font-semibold">Status:</p>
                <p class="mt-2 text-lg leading-8 text-gray-600 mb-5">{{ $ruangan->status }}</p>

                <!-- Button to add to cart or checkout -->
                <form method="POST" action="{{ route('mahasiswa.cart.ruangan.add') }}" id="addToCartForm" class="mt-4 flex gap-4 bottom-0 left-0 right-0">
                    @csrf
                    <input type="hidden" name="id_ruangan" value="{{ $ruangan->id }}">
                    <button type="submit" id="addToCartButton" class="w-full bg-white text-red-500 border border-red-500 font-semibold py-2 rounded shadow-md hover:bg-red-500 hover:text-white transform hover:scale-105 transition">
                        Add to Cart
                    </button>
                    <a href="{{ route('mahasiswa.cart.ruangan.checkout') }}" class="w-full text-center bg-red-500 text-white font-semibold py-2 rounded shadow-md hover:bg-red-600 transform hover:scale-105 transition">
                        Checkout
                    </a>
                </form>
            </div>
        </div>
    </div>
 @endsection
