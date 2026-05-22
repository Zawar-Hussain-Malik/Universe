@extends('student.layout')

@section('title', 'Transport Details')

@section('content')
    <div class="main">
        <div>
            <h3>Transport Information</h3>
            <p class="text-muted">Assigned route and bus details.</p>
        </div>

        @if (!$transport)
            <div class="empty">No transport assignment found.</div>
        @else
            <div class="card">
                <h3>Route {{ $transport->route }}</h3>
                <div class="detail">
                    <span>Bus Number</span>
                    <span>{{ $transport->bus_no }}</span>
                </div>
                <div class="detail">
                    <span>Driver</span>
                    <span>{{ $transport->driver ?? 'TBA' }}</span>
                </div>
                <div class="detail">
                    <span>Updated On</span>
                    <span>{{ $transport->updated_at->format('d M, Y') }}</span>
                </div>
            </div>
        @endif
    </div>
@endsection

