@push('title')
    <title>Password Reset</title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/">Home</a> &gt;&gt; Password Reset
        <h2>Password Reset!</h2>
        <?php if (isset($message)) :?>
        <p><?php echo $message; ?></p>
        <?php endif;?>

        @if (!isset($user->id))
            <form method="POST">
                @csrf
                <table width="100%">
                    <tbody>
                        <tr>
                            <td><label for="email">Username (email):</label></td>
                            <td>
                                @if (isset($request->email))
                                    <input type="email" id="email" name="email" value="{{ $request->email }}" class="form-textbox">
                                @else
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-textbox">
                                @endif
                                @error('email')
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
                                <input type="submit" name="submit" class="btn" value="Submit">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        @endif
    </div>
@endsection
