@push('title')
    <title>Update {{ $afterschool->name }}</title>
@endpush

@extends('layouts.app')

@section('content')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
    
    <div id="left-col">
        <a href="/">Home</a> &gt;&gt;
        <a href="/program-<?php echo $afterschool->id?>-<?php echo $afterschool->filename?>.html"><?php echo $afterschool->name?></a> &gt;&gt;
        Update Afterschool Information
    
        <h2>Update Afterschool Information</h2>
    
        <?php if (isset($message)): ?>
            <p><?php echo $message ?></p>
        <?php endif; ?>
    
        @if( $message == "" )
            <a href="/program/imageupload?id=<?php echo $afterschool->id?>">Upload Images</a>
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
                                    @if( !empty(old('name')) )
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-textbox">
                                    @else
                                        <input type="text" id="name" name="name" value="{{ $afterschool->name }}" class="form-textbox">
                                    @endif
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
                                    @if( !empty(old('address')) )
                                        <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-textbox">
                                    @else
                                        <input type="text" id="address" name="address" value="{{ $afterschool->address }}" class="form-textbox">
                                    @endif
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
                                    @if( !empty(old('city')) )
                                        <input type="text" id="city" name="city" value="{{ old('city') }}" class="form-textbox">
                                    @else
                                        <input type="text" id="city" name="city" value="{{ $afterschool->city }}" class="form-textbox">
                                    @endif
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
                                            @if( !empty(old('state')) )
                                                @if($state->state_code == old('state'))
                                                    <option value='{{ $state->state_code }}' selected>{{ $state->state_name }}</option>
                                                @else
                                                    <option value='{{ $state->state_code }}'>{{ $state->state_name }}</option>
                                                @endif
                                            @else
                                                @if($state->state_code == $afterschool->state)
                                                    <option value='{{ $state->state_code }}' selected>{{ $state->state_name }}</option>
                                                @else
                                                    <option value='{{ $state->state_code }}'>{{ $state->state_name }}</option>
                                                @endif
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
                                    @if( !empty(old('zip')) )
                                        <input type="text" id="zip" name="zip" value="{{ old('zip') }}" class="form-textbox">
                                    @else
                                        <input type="text" id="zip" name="zip" value="{{ $afterschool->zip }}" class="form-textbox">
                                    @endif
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
                                    @if( !empty(old('phone')) )
                                        <input type="text" id="phone" name="phone" value="{{old('phone')}}" class="form-textbox">
                                    @else
                                        <input type="text" id="phone" name="phone" value="{{ $afterschool->phone }}" class="form-textbox">
                                    @endif
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
                                    @if( !empty(old('email')) )
                                        <input type="email" id="email" name="email" value="{{old('email')}}" class="form-textbox">
                                    @else
                                        <input type="email" id="email" name="email" value="{{ $afterschool->email }}" class="form-textbox">
                                    @endif
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
                                    @if( !empty(old('location')) )
                                        <input type="text" id="location" name="location" value="{{old('location')}}" class="form-textbox">
                                    @else
                                        <input type="text" id="location" name="location" value="{{ $afterschool->location }}" class="form-textbox">
                                    @endif
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
                                    @if( !empty(old('capacity')) )
                                        <input type="text" id="capacity" name="capacity" value="{{old('capacity')}}" class="form-textbox">
                                    @else
                                        <input type="text" id="capacity" name="capacity" value="{{ $afterschool->capacity }}" class="form-textbox">
                                    @endif
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
                                    @if( !empty(old('ageRange')) )
                                        <input type="text" id="ageRange" name="ageRange" value="{{old('ageRange')}}" class="form-textbox">
                                    @else
                                        <input type="text" id="ageRange" name="ageRange" value="{{ $afterschool->ageRange }}" class="form-textbox">
                                    @endif
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
                                        @if( !empty(old('status')) )
                                            @foreach($status_arr as $key => $value)
                                                @if($key == old('status'))
                                                    <option value='{{ $key }}' selected>{{ $value }}</option>
                                                @else
                                                    <option value='{{ $key }}'>{{ $value }}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($status_arr as $key => $value)
                                                @if($key == $afterschool->status)
                                                    <option value='{{ $key }}' selected>{{ $value }}</option>
                                                @else
                                                    <option value='{{ $key }}'>{{ $value }}</option>
                                                @endif
                                            @endforeach
                                        @endif   
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
                                    @if( !empty(old('introduction')) )
                                        <textarea id="introduction" name="introduction" cols="15" rows="5">{{old('introduction')}}</textarea>
                                    @else
                                        <textarea id="introduction" name="introduction" cols="15" rows="5">{{ $afterschool->introduction }}</textarea>
                                    @endif
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
                                    @if( !empty(old('website')) )
                                        <input type="text" id="website" name="website" value="{{old('website')}}" class="form-textbox">
                                    @else
                                        <input type="text" id="website" name="website" value="{{ $afterschool->website }}" class="form-textbox">
                                    @endif
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
                                    @if( !empty(old('claim')) )
                                        @if( old('claim') == 1 )
                                            <label class="required"><input type="radio" name="claim" value="1" checked="checked">Yes</label>
                                            <label class="required"><input type="radio" name="claim" value="0">No</label>
                                        @else
                                            <label class="required"><input type="radio" name="claim" value="1">Yes</label>
                                            <label class="required"><input type="radio" name="claim" value="0" checked="checked">No</label>
                                        @endif
                                    @else
                                        @if( $afterschool->claim == 1 )
                                            <label class="required"><input type="radio" name="claim" value="1" checked="checked">Yes</label>
                                            <label class="required"><input type="radio" name="claim" value="0">No</label>
                                        @else
                                            <label class="required"><input type="radio" name="claim" value="1">Yes</label>
                                            <label class="required"><input type="radio" name="claim" value="0" checked="checked">No</label>
                                        @endif
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
