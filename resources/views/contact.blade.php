@push('title')
    <title>Contact</title>
@endpush

@extends('layouts.app')

@section('content')
    <script src="{{ asset('js/tiny_mce/tiny_mce.js') }}"></script>
    <script src="{{ asset('js/tiny_mce/tiny_mce_activate.js') }}"></script>

    <div id="left-col">
        <a href="/">Home</a> &gt;&gt; Contact

        <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
        <?php endif; ?>

        @if( $message != "Email sent successfully" )
            <form method="post">
                @csrf
                <table width="100%">
                    <tbody>
                        <tr>
                            <td><label for="name">Your Name:</label></td>
                            <td>
                                @if( isset($request->name) )
                                    <input type="text" id="name" name="name" value="{{$request->name}}" class="form-textbox">
                                @else
                                    <input type="text" id="name" name="name" value="{{old('name')}}" class="form-textbox">
                                @endif
                                @error('name')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="email">Your e-mail address:</label></td>
                            <td>
                                @if( isset($request->email) )
                                    <input type="email" id="email" name="email" value="{{$request->email}}" class="form-textbox">
                                @else
                                    <input type="email" id="email" name="email" value="{{old('email')}}" class="form-textbox">
                                @endif
                                @error('email')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="subject">Subject:</label></td>
                            <td>
                                @if( isset($request->subject) )
                                    <input type="text" id="subject" name="subject" value="{{$request->subject}}" class="form-textbox">
                                @else
                                    <input type="text" id="subject" name="subject" value="{{old('subject')}}" class="form-textbox">
                                @endif
                                @error('subject')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="message">Message:</label></td>
                            <td>
                                @if( isset($request->message) )
                                    <textarea id="message" name="message" cols="15" rows="5" class="form-textbox">{{$request->message}}</textarea>
                                @else
                                    <textarea id="message" name="message" cols="15" rows="5" class="form-textbox">{{old('message')}}</textarea>
                                @endif
                                @error('message')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="hidden" name="challenge" value="g-recaptcha-response">
                                <script type="text/javascript" src="https://www.google.com/recaptcha/api.js" async="" defer=""></script>
                                <div class="g-recaptcha" data-sitekey="{{ env("DATA_SITEKEY") }}" data-theme="light" data-type="image" data-size="normal">                                
                                </div>
                                @error('recaptcha-token')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="hidden" name="referer" value="{{ isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '' }}">
                                <input type="submit" name="submit" class="btn" value="Send e-mail">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        @endif
    </div>
@endsection
