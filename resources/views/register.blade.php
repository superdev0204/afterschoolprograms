@push('title')
    <title>Create New User</title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/">Home</a>&nbsp;>>&nbsp;User Registration
        <h2>User Registration</h2>
        <?php if (isset($message)) :?>
        <p><?php echo $message; ?></p>
        <?php endif;?>

        @if(!$new_user)
            <form method="post">
                @csrf
                <table width="100%">
                    <tbody>
                        <tr>
                            <td><label class="required" for="type">User Type:</label></td>
                            <td>
                                <select id="type" name="type" class="form-selectbox">
                                    <option value="">Select an option</option>
                                    @if( isset($request->type) )
                                        @if($request->type == "PROVIDER")
                                            <option value="PARENT">Parent</option>
                                            <option value="PROVIDER" selected>Provider</option>
                                        @else
                                            <option value="PARENT" selected>Parent</option>
                                            <option value="PROVIDER">Provider</option>
                                        @endif
                                    @else
                                        @if( !empty(old('type')) )
                                            @if(old('type') == "PROVIDER")
                                                <option value="PARENT">Parent</option>
                                                <option value="PROVIDER" selected>Provider</option>
                                            @else
                                                <option value="PARENT" selected>Parent</option>
                                                <option value="PROVIDER">Provider</option>
                                            @endif
                                        @else
                                            <option value="PARENT">Parent</option>
                                            <option value="PROVIDER">Provider</option>
                                        @endif
                                    @endif
                                </select>
                                @error('type')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="firstName">First Name:</label></td>
                            <td>
                                @if( isset($request->firstName) )
                                    <input type="text" id="firstName" name="firstName" value="{{$request->firstName}}" class="form-textbox">
                                @else
                                    <input id="firstName" name="firstName" type="text" value="{{old('firstName')}}" class="form-textbox">
                                @endif
                                @error('firstName')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="lastName">Last Name:</label></td>
                            <td>
                                @if( isset($request->lastName) )
                                    <input type="text" id="lastName" name="lastName" value="{{$request->lastName}}" class="form-textbox">
                                @else
                                    <input id="lastName" name="lastName" type="text" value="{{old('lastName')}}" class="form-textbox">
                                @endif
                                @error('lastName')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="email">Email address (will be your username):</label></td>
                            <td>
                                @if( isset($request->email) )
                                    <input type="email" id="email" name="email" value="{{$request->email}}" class="form-textbox">
                                @else
                                    <input id="email" name="email" type="email" value="{{old('email')}}" class="form-textbox">
                                @endif
                                @error('email')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="password">Password:</label></td>
                            <td>
                                <input type="password" id="password" name="password" autocomplete="off" class="form-textbox" value="">
                                @error('password')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="password_confirmation">Retype Password:</label></td>
                            <td>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-textbox" value="">
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
                                <input type="hidden" name="challenge" value="g-recaptcha-response">
                                <script type="text/javascript" src="https://www.google.com/recaptcha/api.js" async="" defer=""></script>
                                <div class="g-recaptcha" data-sitekey="{{ env('DATA_SITEKEY') }}"
                                    data-theme="light" data-type="image" data-size="normal">
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
                                <input type="submit" name="submit" class="btn" value="Register">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        @endif
        <!-- / end# content-box  -->
    </div>
@endsection
