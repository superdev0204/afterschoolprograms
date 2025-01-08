@extends('layouts.app_admin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Q/A</li>
        </ol>
    </nav>
    
    <h2>New Questions</h2>
    <a href='/admin/question_editor' style="float:right; margin-right:30px">New Question</a>
    <table class="display" style="width:100%">
        <thead>
            <tr>
                <th>Approve</th>
                <th>Name</th>
                <th>Type</th>
                <th>By</th>
                <th>Questions</th>
                <th>Update</th>
                <th>Not Approve</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
                <tr>
                    <td>
                        <form method="post" action="/admin/question/approve">
                            @csrf
                            <input type="hidden" name="id" value="<?php echo $question->id; ?>" />
                            <input class="btn btn-success" type="submit" value="Approve" />
                        </form>
                    </td>
                    <td><a href="{{ $question->link }}">{{ $question->name }}</a></td>
                    <td>{{ $question->program_type }}</td>
                    <td>{{ $question->question_by }}</td>
                    <td><?php echo $question->question; ?></td>
                    <td>
                        <button type="button"
                            onclick="window.open('/admin/question_editor?id={{ $question->id }}', '_self')">Update</button>
                    </td>
                    <td>
                        <form method="post" action="/admin/question/disapprove">
                            @csrf
                            <input type="hidden" name="id" value="<?php echo $question->id; ?>" />
                            <input class="btn btn-warning" type="submit" value="Not Approve" />
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table><br />
    <h2>New Answers</h2>
    <table class="display" style="width:100%">
        <thead>
            <tr>
                <th>Approve</th>
                <th>Name</th>
                <th>Type</th>
                <th>By</th>
                <th>Answers</th>
                <th>Update</th>
                <th>Not Approve</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($answers as $answer)
                <tr>
                    <td>
                        <form method="post" action="/admin/answer/approve">
                            @csrf
                            <input type="hidden" name="id" value="<?php echo $answer->id; ?>" />
                            <input class="btn btn-success" type="submit" value="Approve" />
                        </form>
                    </td>
                    <td><a href="{{ $answer->link }}">{{ $answer->name }}</a></td>
                    <td>{{ $answer->program_type }}</td>
                    <td>{{ $answer->answer_by }}</td>
                    <td><?php echo $answer->answer; ?></td>
                    <td><button type="button"
                            onclick="window.open('/admin/answer_editor?id={{ $answer->id }}', '_self')">Update</button>
                    </td>
                    <td>
                        <form method="post" action="/admin/answer/disapprove">
                            @csrf
                            <input type="hidden" name="id" value="<?php echo $answer->id; ?>" />
                            <input class="btn btn-warning" type="submit" value="Not Approve" />
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table><br />
    <style>
        button {
            background: #E59500;
            border: 0;
            height: 36px;
            margin-left: 0;
            width: 137px;
            color: #fff;
            cursor: pointer;
        }
    </style>
@endsection
