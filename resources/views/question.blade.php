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
        &gt;&gt; Create Question

        <h2>Create your question for:</h2>
        @if ($program)
            <?php echo $program->name; ?><br />
            <?php echo $program->address . ' ' . $program->city . ' ' . $program->state . ' ' . $program->zip; ?>
        @endif

        <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
        <?php endif; ?>

        @if (!$request->question)
            <form method="post">
                @csrf
                <dl class="zend_form">
                    @if (!$user)
                        <dt id="user-label"><label for="userName">Your Name:</label></dt>
                        <dd id="user-element">
                            @if (isset($request->userName))
                                <input type="text" class="form-textbox" id="userName" name="userName" value="{{ $request->userName }}">
                            @else
                                <input type="text" class="form-textbox" id="userName" name="userName" value="{{ old('userName') }}">
                            @endif
                            @error('userName')
                                <ul style="clear: both">
                                    <li>{{ $message }}</li>
                                </ul>
                            @enderror
                        </dd>
                        <dt id="user-label"><label for="userEmail">Your Email:</label></dt>
                        <dd id="user-element">
                            @if (isset($request->userEmail))
                                <input type="email" class="form-textbox" id="userEmail" name="userEmail" value="{{ $request->userEmail }}">
                            @else
                                <input type="email" class="form-textbox" id="userEmail" name="userEmail" value="{{ old('userEmail') }}">
                            @endif
                            @error('userEmail')
                                <ul style="clear: both">
                                    <li>{{ $message }}</li>
                                </ul>
                            @enderror
                        </dd>
                    @endif
                    <dt id="question-label"><label for="question">Your Question:</label></dt>
                    <dd id="question-element">
                        @if (isset($request->question))
                            <textarea class="form-textbox" id="question" name="question" cols="15" rows="5">{{ $request->question }}</textarea>
                        @else
                            <textarea class="form-textbox" id="question" name="question" cols="15" rows="5">{{ old('question') }}</textarea>
                        @endif
                        @error('question')
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
                    var editor = CKEDITOR.replace('question');
                    editor.setData($('textarea[name="question"]').val());
                    CKFinder.setupCKEditor( editor, '/ckfinder' ) ;
                })
            </script>
        @endif
    </div>
@endsection
