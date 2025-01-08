@push('title')
    <title>Center Search</title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/">Home</a> &gt;&gt; Search
        <p><?php echo $message; ?></p>

        <form method="post" action="/search">
            @csrf
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td><label for="type">I Am Looking For:</label></td>
                        <td>
                            <select id="type" name="type" class="form-selectbox">
                                @if( isset($request->type) )
                                    @foreach($types as $key => $value)
                                        @if($key == $request->type)
                                            <option value='{{ $key }}' selected>{{ $value }}</option>
                                        @else
                                            <option value='{{ $key }}'>{{ $value }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($types as $key => $value)
                                        @if($key == old('type'))
                                            <option value='{{ $key }}' selected>{{ $value }}</option>
                                        @else
                                            <option value='{{ $key }}'>{{ $value }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="location">Enter ZIP Code or City/State:</label></td>
                        <td>
                            @if( isset($request->location) )
                                <input type="text" id="location" name="location" value="{{$request->location}}" class="form-textbox">
                            @else
                                <input type="text" id="location" name="location" value="{{old('location')}}" class="form-textbox">
                            @endif
                            @error('location')
                                <ul>
                                    <li>{{ $message }}</li>
                                </ul>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="name">Name:</label></td>
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
                        <td><label for="address">Address:</label></td>
                        <td>
                            @if( isset($request->address) )
                                <input type="text" id="address" name="address" value="{{$request->address}}" class="form-textbox">
                            @else
                                <input type="text" id="address" name="address" value="{{old('address')}}" class="form-textbox">
                            @endif
                            @error('address')
                                <ul>
                                    <li>{{ $message }}</li>
                                </ul>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="phone">Phone:</label></td>
                        <td>
                            @if( isset($request->phone) )
                                <input type="text" id="phone" name="phone" value="{{$request->phone}}" class="form-textbox">
                            @else
                                <input type="text" id="phone" name="phone" value="{{old('phone')}}" class="form-textbox">
                            @endif
                            @error('phone')
                                <ul>
                                    <li>{{ $message }}</li>
                                </ul>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" class="btn" value="Search">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection
