@extends('layouts.app_admin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Visitor Counts</li>
        </ol>
    </nav>

    <h3 class="page-header">Visitor Counts</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Page Url</th>
                <th>Date</th>
                <th>Visitor Count</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($visitor_counts as $visitor_count)
                <tr>
                    <td>{{ $visitor_count->id }}</td>
                    <td>{{ $visitor_count->page_url }}</td>
                    <td>{{ $visitor_count->date }}</td>
                    <td>{{ $visitor_count->visitor_count }}</td>
                    <td>
                        <a href="/admin/visitor_delete?vID={{ $visitor_count->id }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($visitor_counts instanceof Illuminate\Pagination\LengthAwarePaginator)
        <div class="pagination">
            {{ $visitor_counts->links("pagination::bootstrap-4") }}
        </div>
    @endif
@endsection
