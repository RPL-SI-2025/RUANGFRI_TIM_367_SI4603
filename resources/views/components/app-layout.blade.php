<!-- resources/views/components/app-layout.blade.php -->

<div class="min-h-screen bg-white">
    @include('layouts.navigation') <!-- Include the navigation layout -->

    <main class="py-4 mt-30">
        {{ $slot }} <!-- Content injected here -->
    </main>
</div>
