@extends('admin.layout')

@section('title', 'Helpdesk | UniVerse Admin')

@section('content')
    <div class="content">
        <header>
            <h1>Help Desk Management</h1>
            <p>View, manage, and update helpdesk tickets submitted by users.</p>
        </header>

        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif

        <div class="filters">
            <select id="statusFilter">
                <option value="">All Statuses</option>
                <option value="open">Open</option>
                <option value="pending">Pending</option>
                <option value="closed">Closed</option>
            </select>
            <input type="text" id="ticketSearch" placeholder="Search ticket by user or subject">
        </div>

        <table>
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>User</th>
                    <th>Issue</th>
                    <th>Status</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody id="ticketTableBody">
                @forelse ($tickets as $ticket)
                    <tr data-status="{{ $ticket->status }}" data-search="{{ strtolower($ticket->user->name . ' ' . $ticket->subject) }}">
                        <td>#{{ str_pad($ticket->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $ticket->user->name }} ({{ ucfirst($ticket->user->role) }})</td>
                        <td>{{ $ticket->subject }}</td>
                        <td class="status-{{ $ticket->status }}">{{ ucfirst($ticket->status) }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.helpdesk.update', $ticket) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="status-select">
                                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="pending" {{ $ticket->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No tickets created yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $tickets->links() }}

        <footer>
            All helpdesk activities are logged for quality assurance.
        </footer>
    </div>
@endsection

@push('scripts')
<script>
    const statusFilter = document.getElementById('statusFilter');
    const searchInput = document.getElementById('ticketSearch');
    const rows = document.querySelectorAll('#ticketTableBody tr');

    const filterTickets = () => {
        const status = statusFilter.value;
        const term = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const matchesStatus = !status || row.dataset.status === status;
            const matchesTerm = row.dataset.search.includes(term);
            row.style.display = matchesStatus && matchesTerm ? '' : 'none';
        });
    };

    statusFilter?.addEventListener('change', filterTickets);
    searchInput?.addEventListener('input', filterTickets);
</script>
@endpush

