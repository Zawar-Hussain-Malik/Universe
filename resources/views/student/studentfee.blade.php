@extends('student.layout')

@section('title', 'Fees')

@section('content')
    <div class="main">
        <div>
            <h3>Fee Summary</h3>
            <p class="text-muted">Latest billing information for the current semester.</p>
        </div>

        @if (!$fee)
            <div class="empty">No fee record has been generated yet.</div>
        @else
            <div class="summary-card">
                <div>
                    <p class="text-muted" style="margin:0;">Outstanding Amount</p>
                    <h2>PKR {{ number_format($fee->amount, 0) }}</h2>
                </div>
                <span class="status-pill status-{{ $fee->status }}">
                    {{ ucfirst($fee->status) }}
                </span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Semester Fee</td>
                        <td>PKR {{ number_format($fee->amount, 0) }}</td>
                        <td>{{ optional($fee->due_date)->format('d M, Y') ?? 'N/A' }}</td>
                        <td>{{ ucfirst($fee->status) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
@endsection

