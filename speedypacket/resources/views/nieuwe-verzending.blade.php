@extends('layouts.app')

@section('title', 'Nieuwe Verzending Aanmaken')

@section('content')
    <div class="card max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <i class="fas fa-shipping-fast text-blue-600 text-2xl mr-3"></i>
            <h2 class="text-xl font-semibold text-gray-800">Nieuwe Verzending Aanmaken</h2>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span class="font-medium">Er zijn fouten opgetreden:</span>
                </div>
                <ul class="mt-2 ml-6 list-disc">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('nieuwe-verzending.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="recipient_id" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-2"></i>Naam Ontvanger *
                </label>
                <select id="recipient_id" name="recipient_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Selecteer een ontvanger</option>
                    @foreach($ontvangers as $ontvanger)
                        <option value="{{ $ontvanger->id }}" data-address="{{ $ontvanger->address }}" {{ old('recipient_id') == $ontvanger->id ? 'selected' : '' }}>
                            {{ $ontvanger->name }} ({{ $ontvanger->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="recipient_address" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-map-marker-alt mr-2"></i>Adres Ontvanger *
                </label>
                <textarea id="recipient_address" name="recipient_address" rows="3" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 resize-vertical">{{ old('recipient_address') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-weight-hanging mr-2"></i>Gewicht (kg)
                    </label>
                    <input type="number" id="weight" name="weight" value="{{ old('weight') }}" step="0.01" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>Beschrijving Pakket
                </label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 resize-vertical">{{ old('description') }}</textarea>
            </div>

            <div class="border-t border-gray-200 pt-6 flex flex-col sm:flex-row gap-3 justify-end">
                <a href="{{ route('dashboard') }}" class="btn secondary inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Annuleren
                </a>
                <button type="submit" class="btn inline-flex items-center">
                    <i class="fas fa-save mr-2"></i> Verzending Aanmaken
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('recipient_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const address = selectedOption.getAttribute('data-address');
            document.getElementById('recipient_address').value = address || '';
        });
    </script>
@endsection
