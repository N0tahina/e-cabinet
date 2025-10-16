@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-12 p-8 bg-white rounded-2xl shadow-md border border-gray-100">
    <h1 class="text-3xl font-bold text-center text-blue-700 mb-8">
        📅 Prendre un rendez-vous
    </h1>

    <!-- Formulaire de réservation -->
    <form action="{{ route('rendez-vous.store') }}" method="POST" class="space-y-6">
        @csrf

        <input type="hidden" name="timezone" id="timezone">

        <script>
            // Détection automatique du fuseau horaire du navigateur
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('timezone').value = Intl.DateTimeFormat().resolvedOptions().timeZone;
            });
        </script>

        <!-- Choisir le dentiste -->
        <div>
            <label for="dentiste" class="block mb-2 font-semibold text-gray-700">
                👩‍⚕️ Choisissez un dentiste :
            </label>
            <select id="dentiste" name="dentiste_id"
                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                onchange="window.location='?dentiste_id='+this.value">
                @foreach($dentistes as $dentiste)
                    <option value="{{ $dentiste->id }}" {{ $selectedDentisteId == $dentiste->id ? 'selected' : '' }}>
                        {{ $dentiste->nom }}
                    </option>
                @endforeach
            </select>
            @error('dentiste_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Date et heure -->
        <div>
            <label for="date_heure" class="block mb-2 font-semibold text-gray-700">
                🕒 Date et heure :
            </label>
            <input type="datetime-local" id="date_heure" name="date_heure"
                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                value="{{ old('date_heure') }}">
            @error('date_heure')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Commentaire -->
        <div>
            <label for="commentaire" class="block mb-2 font-semibold text-gray-700">
                💬 Commentaire :
            </label>
            <textarea id="commentaire" name="commentaire" rows="4"
                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                placeholder="Indiquez vos besoins ou questions...">{{ old('commentaire') }}</textarea>
            @error('commentaire')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bouton Réserver -->
        <div class="text-center">
            <button type="submit"
                class="bg-blue-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-blue-500 transition shadow-sm">
                ✅ Réserver le rendez-vous
            </button>
        </div>
    </form>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-xl mt-6 text-center shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Bouton pour afficher le calendrier -->
    <div class="text-center mt-10">
        <button onclick="toggleCalendar()" 
            class="bg-green-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-green-500 transition shadow-sm">
            📆 Voir le calendrier
        </button>
    </div>

    <!-- Calendrier caché au début -->
    <div id="calendar-container" class="mt-8 hidden">
        <div id="calendar" class="bg-gray-50 rounded-xl p-4 border border-gray-200 shadow-inner"></div>
    </div>
</div>
@endsection

@section('scripts')
<!-- FullCalendar scripts -->
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js"></script>

<script>
    function toggleCalendar() {
        const container = document.getElementById('calendar-container');
        container.classList.toggle('hidden');

        if (!container.classList.contains('hidden') && !container.dataset.loaded) {
            initCalendar();
            container.dataset.loaded = true;
        }
    }

    function initCalendar() {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: @json($rendezvous),
            eventDidMount: function(info) {
                if (info.event.extendedProps.statut == 0) {
                    info.el.style.backgroundColor = '#facc15'; // jaune (en attente)
                } else if (info.event.extendedProps.statut == 1) {
                    info.el.style.backgroundColor = '#4ade80'; // vert (validé)
                } else if (info.event.extendedProps.statut == 2) {
                    info.el.style.backgroundColor = '#f87171'; // rouge (refusé)
                }
                info.el.style.borderRadius = '8px';
                info.el.style.color = '#1e293b';
            }
        });

        calendar.render();
    }
</script>
@endsection