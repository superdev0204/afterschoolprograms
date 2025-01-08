@extends('layouts.app_admin')

@section('content')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Answer Editor</li>
        </ol>
    </nav>
    <form method="POST" action="/admin/answer_update">
        @csrf
        <table width="50%">
            @if (isset($answer))
                <tr>
                    <td>
                        <label for="userName">Name:</label>
                    </td>
                    <td>
                        <input type="text" class="form-textbox" id="userName" name="userName" value="{{ $answer->answer_by }}" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="userEmail">Email:</label>
                    </td>
                    <td>
                        <input type="email" class="form-textbox" id="userEmail" name="userEmail" value="{{ $answer->answer_email }}" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="answer_id" id="answer_id" value="{{ $answer->id }}" required>
                        <label for="answer">Answer:</label>
                    </td>
                    <td>
                        <textarea name="answer" id="answer" cols="15" rows="5">{{ $answer->answer }}</textarea>
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
                        <label for="answer">Answer:</label>
                    </td>
                    <td>
                        <textarea name="answer" id="answer" cols="15" rows="5"></textarea>
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
            @endif
        </table>
    </form><br />

    <script type="text/javascript">
        $(function () {
            var editor = CKEDITOR.replace('answer');
            editor.setData($('textarea[name="answer"]').val());
            CKFinder.setupCKEditor( editor, '/ckfinder' ) ;
        })
    </script>
@endsection
