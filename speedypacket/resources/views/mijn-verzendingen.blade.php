@extends('layouts.app')

@section('title', 'Mijn Verzendingen')

@section('content')
    <div class="card max-w-6xl mx-auto bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200">
        <div class="flex items-center mb-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-4 rounded-t-lg">
            <i class="fas fa-list text-2xl mr-3"></i>
            <h2 class="text-xl font-semibold">Mijn Verzendingen</h2>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($packages->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-400 text-6xl mb-4"></i>
                <p class="text-gray-600 mb-4">Je hebt nog geen verzendingen aangemaakt.</p>
                <a href="{{ route('nieuwe-verzending') }}" class="btn inline-flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> Eerste Verzending Aanmaken
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                    <thead class="bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tracking Nummer</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Ontvanger</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Koerier</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Gewicht</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Aangemaakt</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($packages as $package)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $package->tracking_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $package->recipient_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $package->recipient_address }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($package->status === 'in_warehouse')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <i class="fas fa-warehouse mr-1"></i> In Magazijn
                                        </span>
                                    @elseif($package->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> In Behandeling
                                        </span>
                                    @elseif($package->status === 'in_transit')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-truck mr-1"></i> Onderweg
                                        </span>
                                    @elseif($package->status === 'delivered')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Bezorgd
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $package->koerier ? $package->koerier->name : 'Nog niet toegewezen' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $package->weight ? $package->weight . ' kg' : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->created_at->format('d-m-Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('pakketten-volgen', ['tracking_number' => $package->tracking_number]) }}" class="btn secondary inline-flex items-center text-xs">
                                        <i class="fas fa-search mr-1"></i> Volgen
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-end mt-6">
                <a href="{{ route('nieuwe-verzending') }}" class="bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-300">
                    <i class="fas fa-plus-circle mr-2"></i> Nieuwe Verzending
                </a>
                <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Terug naar Dashboard
                </a>
            </div>
        @endif
    </div>
@endsection
