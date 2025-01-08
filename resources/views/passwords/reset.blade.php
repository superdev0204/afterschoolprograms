@push('title')
    <title>Password Reset</title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/">Home</a> &gt;&gt; Password Reset
        <h1>Password Reset!</h1>
        <?php if (isset($message)) :?>
        <p><?php echo $message; ?></p>
        <?php endif;?>

        <form method="POST">
            @csrf
            <table width="100%">
                <tbody>
                    <tr>
                        <td><label for="password">Password:</label></td>
                        <td>
                            <input type="password" id="password" name="password" autocomplete="off" value="" class="form-textbox">
                            @error('password')
                                <ul>
                                    <li>{{ $message }}</li>
                                </ul>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="password_confirmation">Retype Password:</label></td>
                        <td>
                            <input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-textbox">
                            @error('password_confirmation')
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
    </div>
@endsection
