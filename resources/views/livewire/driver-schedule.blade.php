@php use Carbon\Carbon; @endphp

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">

        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-6 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Rijschema Ziekenhuisvervoer</h1>
            <div class="max-w-2xl mx-auto">
                <p class="text-lg text-gray-600 leading-relaxed">
                    Help jij Kelsey door met haar mee te rijden naar het ziekenhuis in Enschede?
                    Jouw steun betekent ontzettend veel.
                </p>
            </div>
        </div>

        <div class="grid lg:grid-cols-7 gap-8">

            <!-- Registration Form -->
            <div class="lg:col-span-2" id="driver-form">
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Word Chauffeur</h3>
                        <p class="text-gray-600">Meld je aan voor een beschikbare datum</p>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-6">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                Jouw Naam
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" wire:model="name" id="name"
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                       placeholder="Voer je naam in">
                            </div>
                            @error('name')
                            <p class="text-red-500 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="selectedDate" class="block text-sm font-semibold text-gray-700">
                                Selecteer Datum
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <select wire:model="selectedDate" id="selectedDate"
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 appearance-none bg-white">
                                    <option value="">Kies een beschikbare datum</option>
                                    @foreach($availableDates as $date)
                                        <option value="{{ $date->format('d-m-Y H:i') }}">
                                            {{ Carbon::parse($date)->locale('nl')->translatedFormat('l j F, H:i') }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('selectedDate')
                            <p class="text-red-500 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Registreer als Chauffeur</span>
                        </button>
                    </form>

                    <!-- Help Text -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-medium mb-1">Volgende stappen:</p>
                                <p class="mt-2">Let op: op donderdagen vindt zowel de chemo als de bestraling plaats. Deze combinatiebehandeling duurt ongeveer 5 uur.</p>
                                <p>Op de overige dagen duurt een behandeling maximaal 1 uur.</p>
                                <p class="mt-2">Zorg ervoor dat je minimaal 50 minuten van tevoren bij Kelsey aanwezig bent.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Display -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <div class="mt-4 mb-4 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-2xl font-bold text-blue-900">{{ collect($schedule)->filter()->count() }}</div>
                                <div class="text-sm text-blue-700">Toegewezen</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-600">{{ collect($schedule)->reject()->count() }}</div>
                                <div class="text-sm text-gray-600">Beschikbaar</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-green-700">{{ count($schedule) }}</div>
                                <div class="text-sm text-green-700">Totaal Dagen</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Planning Overzicht</h3>
                            <p class="text-gray-600">Huidige stand van zaken voor alle geplande ritten</p>
                        </div>
                        <div class="flex items-center space-x-4 text-sm">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-gray-600">Toegewezen</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                                <span class="text-gray-600">Beschikbaar</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-4">
                        @foreach($schedule as $date => $driver)
                            <div class="group relative overflow-hidden rounded-xl border-2 transition-all duration-300 hover:shadow-lg {{ $driver ? 'border-green-200 bg-gradient-to-br from-green-50 to-emerald-50' : 'border-gray-200 bg-gray-50 hover:border-blue-200 hover:bg-blue-50' }}">

                                <!-- Date Header -->
                                <div class="p-5">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 {{ $driver ? 'bg-green-100' : 'bg-gray-200' }} rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 {{ $driver ? 'text-green-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 text-lg">
                                                    {{ Carbon::parse($date)->locale('nl')->translatedFormat('l j F, H:i') }}
                                                    @php
                                                        $dayOfWeek = Carbon::parse($date)->locale('nl')->dayName;
                                                    @endphp

                                                    @if(strtolower($dayOfWeek) === 'donderdag')
                                                        <p class="text-sm text-red-600 font-semibold">
                                                            Afspraakduur: 5 uur
                                                        </p>
                                                    @endif
                                                </h4>
                                                <p class="text-sm text-gray-600">
                                                    {{ Carbon::parse($date)->locale('nl')->translatedFormat('d-m-y H:i') }}
                                                </p>
                                            </div>
                                        </div>

                                        @if($driver)
                                            <div class="flex items-center space-x-2">
                                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                                <span class="text-xs font-medium text-green-700 uppercase tracking-wider">Toegewezen</span>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-2">
                                                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Beschikbaar</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Driver Info or Available Slot -->
                                    @if($driver)
                                        <div class="bg-white/80 backdrop-blur-sm border border-green-200 rounded-lg p-4 transition-all duration-200">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-gray-900">{{ $driver->name }}</p>
                                                        <p class="text-sm text-gray-600">Chauffeur</p>
                                                    </div>
                                                </div>
                                                <button wire:click="delete({{ $driver->id }})"
                                                        class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200 group">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <a href="#driver-form">
                                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center group-hover:border-blue-300 transition-colors duration-200">
                                                <svg class="w-8 h-8 text-gray-400 mx-auto mb-2 group-hover:text-blue-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                <p class="text-sm text-gray-500 group-hover:text-blue-600 transition-colors duration-200">
                                                    Nog geen chauffeur
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    Meld je aan om te helpen
                                                </p>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Message -->
        <div class="mt-12 text-center">
            <div class="text-gray-500 text-xs mt-4"><a href="https://tomemming.nl">Made with ❤️ by Tom Emming</a></div>
        </div>

    </div>
</div>
