@push('title')
    <title>Member Login</title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/">Home</a> &gt;&gt; User Login
        <h2>User Login</h2>

        @if (request()->query('return_url'))
            <?php 
                $return_url = explode("/", request()->query('return_url'));
                $id = $return_url[count($return_url)-1];
                if (str_contains(request()->query('return_url'), 'program')) {
                    $type = "afterschool";
                } else {
                    $type = "activity";
                }
            ?>
            <p>If you don't have a Login Account yet, please <a href="/user/new?id={{ $id }}&type={{ $type }}">Click here to Register</a>.</p>
        @else
            <p>If you don't have a Login Account yet, please <a href="/user/new">Click here to Register</a>.</p>
        @endif

        <?php if (isset($errorMessage)) :?>
        <p><?php echo $errorMessage; ?></p>
        <?php endif;?>

        <form method="POST" id="login">
            @csrf
            <table width="100%">
                <tbody>
                    <tr>
                        <td>
                            <label for="username">Username (email):</label>
                        </td>
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
                        <td>
                            <label for="password">Password:</label>
                        </td>
                        <td>
                            <input type="password" id="password" name="password" class="form-textbox" value="">
                            @error('password')
                                <ul>
                                    <li>{{ $message }}</li>
                                </ul>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" class="btn" value="Login">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        <br />
        <?php if (isset($errorMessage)) :?>
        <p>If you forget your password, click <a href="/user/reset">reset password</a>. </p>
        <?php endif; ?>
    </div>
@endsection
