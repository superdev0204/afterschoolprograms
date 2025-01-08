@extends('layouts.app_admin')

@section('content')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Question Editor</li>
        </ol>
    </nav>

    <form method="POST" action="/admin/question_update">
        @csrf
        <table width="50%">
            @if (isset($question))
                <tr>
                    <td>
                        <label for="userName">Name:</label>
                    </td>
                    <td>
                        <input type="text" class="form-textbox" id="userName" name="userName" value="{{ $question->question_by }}" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="userEmail">Email:</label>
                    </td>
                    <td>
                        <input type="email" class="form-textbox" id="userEmail" name="userEmail" value="{{ $question->question_email }}" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="question_id" id="question_id" value="{{ $question->id }}" required>
                        <label for="question">Question:</label>
                    </td>
                    <td>
                        <textarea name="question" id="question" cols="15" rows="5">{{ $question->question }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <button type="submit" class="form-content-submit-btn">Update</button>
                    </td>
                </tr>
            @else
                <tr>
                    <td>
                        <label for="program_type">Category:</label>
                    </td>
                    <td>
                        <select id="program_type" name="program_type" class="form-selectbox">
                            <option value="">All categories</option>
                            <option value="afterschool">After School</option>
                            <option value="martial_arts">Martial Arts</option>
                            <option value="youth_sports">Youth Sports</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="question">Question:</label>
                    </td>
                    <td>
                        <textarea name="question" id="question" cols="15" rows="5"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <button type="submit" class="form-content-submit-btn">Submit Question</button>
                    </td>
                </tr>
            @endif
        </table>
    </form><br />

    <script type="text/javascript">
        $(function () {
            var editor = CKEDITOR.replace('question');
            editor.setData($('textarea[name="question"]').val());
            CKFinder.setupCKEditor( editor, '/ckfinder' ) ;
        })
    </script>
@endsection
