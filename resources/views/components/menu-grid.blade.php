<!-- resources/views/components/menu-grid.blade.php -->
<div class="menu-item bg-white p-4 rounded-lg shadow-lg text-center" data-category="{{ $item['category'] ?? '' }}">
    <a href="{{ route('menu.show', ['menu' => $item['name']]) }}">
        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-40 object-cover mb-4 rounded">
        <h5 class="text-xl font-semibold">{{ $item['name'] }}</h5>
        <p class="text-gray-600">
            @if(isset($item['price']['hot']))
                Hot: {{ number_format($item['price']['hot'], 0, ',', '.') }}k
            @endif
            @if(isset($item['price']['ice']))
                / Ice: {{ number_format($item['price']['ice'], 0, ',', '.') }}k
            @endif
        </p>
    </a>
</div>
