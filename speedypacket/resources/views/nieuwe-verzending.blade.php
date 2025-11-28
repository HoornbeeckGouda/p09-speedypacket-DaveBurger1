@extends('layouts.app')

@section('title', 'Nieuwe Verzending Aanmaken')

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 24px;"><i class="fas fa-plus-circle"></i> Nieuwe Verzending Aanmaken</h2>

        @if($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 18px; border: 1px solid #fecaca;">
                <i class="fas fa-exclamation-triangle"></i>
                <ul style="margin: 8px 0 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('nieuwe-verzending.store') }}" method="POST" style="display: grid; gap: 18px;">
            @csrf

            <div>
                <label for="recipient_id" style="display: block; margin-bottom: 6px; font-weight: 600;">Naam Ontvanger *</label>
                <select id="recipient_id" name="recipient_id" required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                    <option value="">Selecteer een ontvanger</option>
                    @foreach($ontvangers as $ontvanger)
                        <option value="{{ $ontvanger->id }}" data-address="{{ $ontvanger->address }}" {{ old('recipient_id') == $ontvanger->id ? 'selected' : '' }}>
                            {{ $ontvanger->name }} ({{ $ontvanger->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="recipient_address" style="display: block; margin-bottom: 6px; font-weight: 600;">Adres Ontvanger *</label>
                <textarea id="recipient_address" name="recipient_address" rows="3" required
                          style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; resize: vertical;">{{ old('recipient_address') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                <div>
                    <label for="weight" style="display: block; margin-bottom: 6px; font-weight: 600;">Gewicht (kg)</label>
                    <input type="number" id="weight" name="weight" value="{{ old('weight') }}" step="0.01" min="0"
                           style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                </div>

                <div></div>
            </div>

            <div>
                <label for="description" style="display: block; margin-bottom: 6px; font-weight: 600;">Beschrijving Pakket</label>
                <textarea id="description" name="description" rows="3"
                          style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; resize: vertical;">{{ old('description') }}</textarea>
            </div>

            <div style="border-top: 1px solid #e5e7eb; padding-top: 18px; display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('dashboard') }}" class="btn secondary">
                    <i class="fas fa-arrow-left"></i> Annuleren
                </a>
                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Verzending Aanmaken
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
