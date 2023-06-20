@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="card rounded-3">
                    <div class="card-body p-4">
                        <h4 class="text-center my-3 pb-3">To Do List</h4>
                        <a class="btn btn-success ms-1" href="{{ route('new_task') }}">
                            New task
                        </a>
                        <div class="col col-lg-12 col-xl-12">

                            <table class="table mb-4">
                                <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Assignment</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tasks as $t)
                                    <tr>
                                        <th scope="row">{{ $loop->index }}</th>
                                        <td>{{ $t['title'] }}</td>
                                        <td>{{ $t['content'] }}</td>
                                        <td>{{ $t['name'] ?? '' }}</td>
                                        <td>{{ $t['status'] }}</td>
                                        <td>
                                            <a class="btn btn-info ms-1" href="{{ route('edit_task', $t['id']) }}">
                                                Edit
                                            </a>
                                            <a id="{{ 'delete_task_'.$t['id'] }}"href="{{ route('delete_task', $t['id']) }}" hidden="true"></a>
                                            <a onclick="if (confirm('Delete?')) {document.getElementById('delete_task_' + {{ $t['id'] }}).click()}" class="btn btn-danger ms-1">Delete</a>
                                            <a id="{{ 'finish_task_'.$t['id'] }}" href="{{ route('finish_task', $t['id']) }}" hidden="true"></a>
                                            <a class="btn btn-success ms-1" onclick="if (confirm('Finished?')) {document.getElementById('finish_task_' + {{ $t['id'] }}).click()}">
                                                Finished
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
