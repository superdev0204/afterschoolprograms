@push('title')
    <title>Add Afterschool</title>
@endpush

@extends('layouts.app')

@section('content')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>

    <div id="left-col">
        <a href="/">Home</a> &gt;&gt; Add New Afterschool

        <h2>Add Afterschool</h2>

        <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
        <?php endif; ?>

        @if (!isset($afterschool->id))
            <form method="post" class="form-horizontal">
                @csrf
                <table width="100%">
                    <tbody>
                        <tr>
                            <td><label class="required" for="name">Name:</label></td>
                            <td>
                                @if (isset($request->name))
                                    <input type="text" id="name" name="name" value="{{ $request->name }}" class="form-textbox">
                                @else
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-textbox">
                                @endif
                                @error('name')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="address">Address:</label></td>
                            <td>
                                @if (isset($request->address))
                                    <input type="text" id="address" name="address" value="{{ $request->address }}" class="form-textbox">
                                @else
                                    <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-textbox">
                                @endif
                                @error('address')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="city">City:</label></td>
                            <td>
                                @if (isset($request->city))
                                    <input type="text" id="city" name="city" value="{{ $request->city }}" class="form-textbox">
                                @else
                                    <input type="text" id="city" name="city" value="{{ old('city') }}" class="form-textbox">
                                @endif
                                @error('city')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="state">State:</label></td>
                            <td>
                                <select id="state" name="state" class="form-selectbox">
                                    <option value="">-Select-</option>
                                    @foreach ($states as $state)
                                        @if( isset($request->state) )
                                            @if($state->state_code == $request->state)
                                                <option value='{{ $state->state_code }}' selected>{{ $state->state_name }}</option>
                                            @else
                                                <option value='{{ $state->state_code }}'>{{ $state->state_name }}</option>
                                            @endif
                                        @else                                        
                                            @if($state->state_code == old('state'))
                                                <option value='{{ $state->state_code }}' selected>{{ $state->state_name }}</option>
                                            @else
                                                <option value='{{ $state->state_code }}'>{{ $state->state_name }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                                @error('state')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="zip">Zip Code:</label></td>
                            <td>
                                @if (isset($request->zip))
                                    <input type="text" id="zip" name="zip" value="{{ $request->zip }}" class="form-textbox">
                                @else
                                    <input type="text" id="zip" name="zip" value="{{ old('zip') }}" class="form-textbox">
                                @endif
                                @error('zip')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="phone">Phone:</label></td>
                            <td>
                                @if (isset($request->phone))
                                    <input type="text" id="phone" name="phone" value="{{ $request->phone }}" class="form-textbox">
                                @else
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-textbox">
                                @endif
                                @error('phone')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="email">Email:</label></td>
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
                            <td><label for="location">Location:</label></td>
                            <td>
                                @if (isset($request->location))
                                    <input type="text" id="location" name="location" value="{{ $request->location }}" class="form-textbox">
                                @else
                                    <input type="text" id="location" name="location" value="{{ old('location') }}" class="form-textbox">
                                @endif
                                @error('location')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="capacity">Capacity:</label></td>
                            <td>
                                @if (isset($request->capacity))
                                    <input type="text" id="capacity" name="capacity" value="{{ $request->capacity }}" class="form-textbox">
                                @else
                                    <input type="text" id="capacity" name="capacity" value="{{ old('capacity') }}" class="form-textbox">
                                @endif
                                @error('capacity')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="ageRange">Age Range:</label></td>
                            <td>
                                @if (isset($request->ageRange))
                                    <input type="text" id="ageRange" name="ageRange" value="{{ $request->ageRange }}" class="form-textbox">
                                @else
                                    <input type="text" id="ageRange" name="ageRange" value="{{ old('ageRange') }}" class="form-textbox">
                                @endif
                                @error('ageRange')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="status">Status:</label></td>
                            <td>
                                <select id="status" name="status" class="form-selectbox">
                                    <option value="">Select your Status</option>
                                    @if( isset($request->status) )
                                        @foreach($status_arr as $key => $value)
                                            @if($key == $request->status)
                                                <option value='{{ $key }}' selected>{{ $value }}</option>
                                            @else
                                                <option value='{{ $key }}'>{{ $value }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($status_arr as $key => $value)
                                            @if($key == old('status'))
                                                <option value='{{ $key }}' selected>{{ $value }}</option>
                                            @else
                                                <option value='{{ $key }}'>{{ $value }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                @error('status')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="introduction">Introduction:</label></td>
                            <td>
                                @if (isset($request->introduction))
                                    <textarea id="introduction" name="introduction" cols="15" rows="5">{{ $request->introduction }}</textarea>
                                @else
                                    <textarea id="introduction" name="introduction" cols="15" rows="5">{{ old('introduction') }}</textarea>
                                @endif
                                @error('introduction')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="website">Website:</label></td>
                            <td>
                                @if (isset($request->website))
                                    <input type="text" id="website" name="website" value="{{ $request->website }}" class="form-textbox">
                                @else
                                    <input type="text" id="website" name="website" value="{{ old('website') }}" class="form-textbox">
                                @endif
                                @error('website')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required">Claim</label></td>
                            <td>
                                @if (isset($request->claim))
                                    @if( $request->claim == 1 )
                                        <label class="required"><input type="radio" name="claim" value="1" checked="checked">Yes</label>
                                        <label class="required"><input type="radio" name="claim" value="0">No</label>
                                    @else
                                        <label class="required"><input type="radio" name="claim" value="1">Yes</label>
                                        <label class="required"><input type="radio" name="claim" value="0" checked="checked">No</label>
                                    @endif
                                @else
                                    @if( old('claim') == 1 )
                                        <label class="required"><input type="radio" name="claim" value="1" checked="checked">Yes</label>
                                        <label class="required"><input type="radio" name="claim" value="0">No</label>
                                    @else
                                        <label class="required"><input type="radio" name="claim" value="1">Yes</label>
                                        <label class="required"><input type="radio" name="claim" value="0" checked="checked">No</label>
                                    @endif
                                @endif
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

    <script type="text/javascript">
        $(function() {
            var editor = CKEDITOR.replace('introduction');
            editor.setData($('textarea[name="introduction"]').val());
            CKFinder.setupCKEditor(editor, '/ckfinder');
        })
    </script>
@endsection
