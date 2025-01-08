@push('title')
    <title>Add Activity</title>
@endpush

@extends('layouts.app')

@section('content')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
    
    <div id="left-col">
        <a href="/">Home</a> &gt;&gt; Add New Activity

        <h2>Add Activity</h2>

        <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
        <?php endif; ?>

        @if (!isset($activity->id))
            <form method="post">
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
                            <td><label for="note">Note:</label></td>
                            <td>
                                @if (isset($request->note))
                                    <textarea id="note" name="note" cols="15" rows="5">{{ $request->note }}</textarea>
                                @else
                                    <textarea id="note" name="note" cols="15" rows="5">{{ old('note') }}</textarea>
                                @endif
                                @error('note')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="details">Details:</label></td>
                            <td>
                                @if (isset($request->details))
                                    <textarea id="details" name="details" cols="15" rows="5">{{ $request->details }}</textarea>
                                @else
                                    <textarea id="details" name="details" cols="15" rows="5">{{ old('details') }}</textarea>
                                @endif
                                @error('details')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="url">Url:</label></td>
                            <td>
                                @if (isset($request->url))
                                    <input type="text" id="url" name="url" value="{{ $request->url }}" class="form-textbox">
                                @else
                                    <input type="text" id="url" name="url" value="{{ old('url') }}" class="form-textbox">
                                @endif
                                @error('url')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="kidsProgramUrl">Kids Program Url:</label></td>
                            <td>
                                @if (isset($request->kidsProgramUrl))
                                    <input type="text" id="kidsProgramUrl" name="kidsProgramUrl" value="{{ $request->kidsProgramUrl }}" class="form-textbox">
                                @else
                                    <input type="text" id="kidsProgramUrl" name="kidsProgramUrl" value="{{ old('kidsProgramUrl') }}" class="form-textbox">
                                @endif
                                @error('kidsProgramUrl')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="summerProgramUrl">Summer Program Url:</label></td>
                            <td>
                                @if (isset($request->summerProgramUrl))
                                    <input type="text" id="summerProgramUrl" name="summerProgramUrl" value="{{ $request->summerProgramUrl }}" class="form-textbox">
                                @else
                                    <input type="text" id="summerProgramUrl" name="summerProgramUrl" value="{{ old('summerProgramUrl') }}" class="form-textbox">
                                @endif
                                @error('summerProgramUrl')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label for="videoUrl">Video Url:</label></td>
                            <td>
                                @if (isset($request->videoUrl))
                                    <input type="text" id="videoUrl" name="videoUrl" value="{{ $request->videoUrl }}" class="form-textbox">
                                @else
                                    <input type="text" id="videoUrl" name="videoUrl" value="{{ old('videoUrl') }}" class="form-textbox">
                                @endif
                                @error('videoUrl')
                                    <ul>
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="claim">Claim</label></td>
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
        $(function () {
            var editor = CKEDITOR.replace('note');
            editor.setData($('textarea[name="note"]').val());
            CKFinder.setupCKEditor( editor, '/ckfinder' ) ;
    
            var editor = CKEDITOR.replace('details');
            editor.setData($('textarea[name="details"]').val());
            CKFinder.setupCKEditor( editor, '/ckfinder' ) ;
        })
    </script>
@endsection
