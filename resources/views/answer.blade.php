@extends('layouts.app')

@section('content')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>

    <div id="left-col">
        <a href="/">Home</a> &gt;&gt;
        @if ($program)
            <?php if ($programType == 'activity'): ?>
            <?php if ($program->category == 'MARTIAL-ARTS'): ?>
            <a href="/activity-<?php echo $program->id; ?>-<?php echo $program->filename; ?>.html"><?php echo $program->name; ?></a>
            <?php else: ?>
            <a href="/sportclub-<?php echo $program->id; ?>-<?php echo $program->filename; ?>.html"><?php echo $program->name; ?></a>
            <?php endif; ?>
            <?php else: ?>
            <a href="/program-<?php echo $program->id; ?>-<?php echo $program->filename; ?>.html"><?php echo $program->name; ?></a>
            <?php endif; ?>
        @else
            <a href="<?php echo $page_url; ?>">Previous Page</a>
        @endif
        &gt;&gt; Create Answer

        <h2>Create your comment for:</h2>
        @if ($program)
            <?php echo $program->name; ?><br />
            <?php echo $program->address . ' ' . $program->city . ' ' . $program->state . ' ' . $program->zip; ?><br /><br />
        @endif
        Q: <?php echo $question->question; ?><br /><br />

        <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
        <?php endif; ?>

        @if (!$request->answer)
            <form method="post">
                @csrf
                <dl class="zend_form">
                    @if (!$user)
                        <dt id="user-label"><label for="answer_userName">Your Name:</label></dt>
                        <dd id="user-element">
                            @if (isset($request->answer_userName))
                                <input type="text" class="form-textbox" id="answer_userName" name="answer_userName"
                                    value="{{ $request->answer_userName }}">
                            @else
                                <input type="text" class="form-textbox" id="answer_userName" name="answer_userName"
                                    value="{{ old('answer_userName') }}">
                            @endif
                            @error('answer_userName')
                                <ul style="clear: both">
                                    <li>{{ $message }}</li>
                                </ul>
                            @enderror
                        </dd>
                        <dt id="user-label"><label for="answer_userEmail">Your Email:</label></dt>
                        <dd id="user-element">
                            @if (isset($request->answer_userEmail))
                                <input type="email" class="form-textbox" id="answer_userEmail" name="answer_userEmail"
                                    value="{{ $request->answer_userEmail }}">
                            @else
                                <input type="email" class="form-textbox" id="answer_userEmail" name="answer_userEmail"
                                    value="{{ old('answer_userEmail') }}">
                            @endif
                            @error('answer_userEmail')
                                <ul style="clear: both">
                                    <li>{{ $message }}</li>
                                </ul>
                            @enderror
                        </dd>
                    @endif
                    <dt id="answer-label"><label for="userName">Your Answer:</label></dt>
                    <dd id="answer-element">
                        @if (isset($request->answer))
                            <textarea class="form-textbox" id="answer" name="answer" cols="15" rows="5">{{ $request->answer }}</textarea>
                        @else
                            <textarea class="form-textbox" id="answer" name="answer" cols="15" rows="5">{{ old('answer') }}</textarea>
                        @endif
                        @error('answer')
                            <ul style="clear: both">
                                <li>{{ $message }}</li>
                            </ul>
                        @enderror
                    </dd>
                    @if (!$user)
                        <dt id="challenge-label">&nbsp;</dt>
                        <dd id="challenge-element">
                            <input type="hidden" name="challenge" value="g-recaptcha-response">
                            <script type="text/javascript" src="https://www.google.com/recaptcha/api.js" async="" defer=""></script>
                            <div class="g-recaptcha" data-sitekey="{{ env('DATA_SITEKEY') }}" data-theme="light"
                                data-type="image" data-size="normal">
                            </div>
                            @error('recaptcha-token')
                                <ul style="clear: both">
                                    <li>{{ $message }}</li>
                                </ul>
                            @enderror
                        </dd>
                    @endif
                    <dt id="addComment-label">&nbsp;</dt>
                    <dd id="addComment-element">
                        <input type="submit" name="submit" value="Submit">
                    </dd>
                </dl>
            </form>

            <script type="text/javascript">
                $(function () {
                    var editor = CKEDITOR.replace('answer');
                    editor.setData($('textarea[name="answer"]').val());
                    CKFinder.setupCKEditor( editor, '/ckfinder' ) ;
                })
            </script>
        @endif
    </div>
@endsection
