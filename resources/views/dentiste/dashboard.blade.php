@extends('dentiste.layout')

@section('title', 'Dashboard Dentiste')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vos prochains rendez-vous')

<!-- On ajoute le CSS spécifique au dashboard -->
@push('styles')
<link rel="stylesheet" href="{{ asset('css/dentiste-dashboard.css') }}">
@endpush

@section('content')
    <section class="appointments-section">
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Date & Heure</th>
                    <th>Commentaire</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jean Dupont</td>
                    <td>20/01/2026 09:00</td>
                    <td>Nettoyage dentaire</td>
                    <td><span class="status pending">En attente</span></td>
                </tr>
                <tr>
                    <td>Marie Claire</td>
                    <td>20/01/2026 10:30</td>
                    <td>Consultation molaire</td>
                    <td><span class="status confirmed">Confirmé</span></td>
                </tr>
                <tr>
                    <td>Paul Martin</td>
                    <td>21/01/2026 14:00</td>
                    <td>Extraction</td>
                    <td><span class="status canceled">Annulé</span></td>
                </tr>
            </tbody>
        </table>
    </section>
@endsection