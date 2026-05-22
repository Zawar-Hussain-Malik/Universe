@extends('student.layout')

@section('title', 'Helpdesk')

@section('content')
    <div class="main">
        <div>
            <h3>Helpdesk</h3>
            <p class="text-muted">Create support tickets and view their status.</p>
        </div>

        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif

        <div class="grid">
            <form method="POST" action="{{ route('student.helpdesk.store') }}">
                @csrf
                <h4 class="form-title">New Ticket</h4>
                <div>
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" required>
                    @error('subject')
                        <small class="alert-error">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Message</label>
                    <textarea rows="5" name="message" required>{{ old('message') }}</textarea>
                    @error('message')
                        <small class="alert-error">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn">Submit Ticket</button>
            </form>

            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->subject }}</td>
                                <td><span class="status {{ $ticket->status }}">{{ $ticket->status }}</span></td>
                                <td>{{ $ticket->created_at->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty">No tickets yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

