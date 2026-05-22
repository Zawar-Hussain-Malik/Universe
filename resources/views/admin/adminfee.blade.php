@extends('admin.layout')

@section('title', 'Fees | UniVerse Admin')

@section('content')
    <div class="content">
        <div class="summary-cards">
            <div class="summary-card">
                <h4>Pending Amount</h4>
                <span>PKR {{ number_format($feeSummary['pending'], 0) }}</span>
            </div>
            <div class="summary-card">
                <h4>Paid Amount</h4>
                <span>PKR {{ number_format($feeSummary['paid'], 0) }}</span>
            </div>
            <div class="summary-card">
                <h4>Overdue Amount</h4>
                <span>PKR {{ number_format($feeSummary['overdue'], 0) }}</span>
            </div>
        </div>

        <div class="table-card">
            <h4>Fee Status</h4>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Department</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fees as $index => $fee)
                        <tr>
                            <td>{{ $fees->firstItem() + $index }}</td>
                            <td>{{ $fee->student->user->name }}</td>
                            <td>{{ $fee->student->department ?? 'N/A' }}</td>
                            <td>PKR {{ number_format($fee->amount, 0) }}</td>
                            <td>
                                <span class="status status-{{ $fee->status }}">{{ $fee->status }}</span>
                            </td>
                            <td>{{ optional($fee->due_date)->format('d M, Y') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No fee records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $fees->links() }}
        </div>
    </div>
@endsection

