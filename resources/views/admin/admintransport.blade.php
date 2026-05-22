@extends('admin.layout')

@section('title', 'Transport | UniVerse Admin')

@section('content')
    <div class="content">
        <h1 class="page-title">Transport Management</h1>
        <p class="page-subtitle">Active routes for the current semester.</p>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Route</th>
                        <th>Bus No</th>
                        <th>Driver</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($routes as $index => $route)
                        <tr>
                            <td>{{ $routes->firstItem() + $index }}</td>
                            <td>{{ $route->student->user->name }}</td>
                            <td>{{ $route->route }}</td>
                            <td>{{ $route->bus_no }}</td>
                            <td>{{ $route->driver ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No transport assignments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $routes->links() }}
        </div>
    </div>
@endsection

