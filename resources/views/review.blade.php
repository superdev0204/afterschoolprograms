@extends('layouts.app')

@section('content')
    <script src="{{ asset('js/tiny_mce/tiny_mce.js') }}"></script>
    <script src="{{ asset('js/tiny_mce/tiny_mce_activate.js') }}"></script>

    <div id="left-col">
        <a href="/">Home</a>  &gt;&gt;
        <?php if (isset($activity)): ?>
            <a href=""><?php echo $activity->name?></a>
        <?php else: ?>
            <a href="/program-<?php echo $afterschool->id?>-<?php echo $afterschool->filename?>.html"><?php echo $afterschool->name?></a>
        <?php endif; ?>
        &gt;&gt; Create Review
    
        <h2>Create your review for: </h2>
    
        <?php if (isset($activity)): ?>
            <?php echo $activity->name ?><br />
            <?php echo $activity->address . " " . $activity->city . " " . $activity->state . " " . $activity->zip ?><br />
        <?php else: ?>
            <?php echo $afterschool->name ?><br />
            <?php echo $afterschool->address . " " . $afterschool->city . " " . $afterschool->state . " " . $afterschool->zip ?><br />
        <?php endif; ?>
    
        <?php if (isset($message)): ?>
            <p><?php echo $message ?></p>
        <?php endif; ?>
    
        @if (!isset($review->commentable_id))
            <form method="post" action="/review/new">
                @csrf
                <table width="100%">
                    <tbody>
                        <tr>
                            <td><label class="required" for="email">Email address (will not be published):</label></td>
                            <td>
                                @if( isset($request->email) )
                                    <input type="email" id="email" name="email" value="{{$request->email}}" class="form-textbox">
                                @else
                                    <input type="email" id="email" name="email" value="{{old('email')}}" class="form-textbox">
                                @endif
                                @error('email')
                                    <ul style="clear: both">
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="reviewBy">Display Name:</label></td>
                            <td>
                                @if( isset($request->reviewBy) )
                                    <input type="text" id="reviewBy" name="reviewBy" value="{{$request->reviewBy}}" class="form-textbox">
                                @else
                                    <input type="text" id="reviewBy" name="reviewBy" value="{{old('reviewBy')}}" class="form-textbox">
                                @endif
                                @error('reviewBy')
                                    <ul style="clear: both">
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="rating">Rating (1=poor, 5=exellent):</label></td>
                            <td>
                                <select id="rating" name="rating" class="form-selectbox">
                                    <option value="">Select Your Rating</option>
                                    @if( isset($request->rating) )
                                        @foreach($rating as $key => $value)
                                            @if($key == $request->rating)
                                                <option value='{{ $key }}' selected>{{ $value }}</option>
                                            @else
                                                <option value='{{ $key }}'>{{ $value }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($rating as $key => $value)
                                            @if($key == old('rating'))
                                                <option value='{{ $key }}' selected>{{ $value }}</option>
                                            @else
                                                <option value='{{ $key }}'>{{ $value }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                @error('rating')
                                    <ul style="clear: both">
                                        <li>{{ $message }}</li>
                                    </ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td><label class="required" for="comments">Write your comment:</label></td>
                            <td>
                                @if( isset($request->comments) )
                                    <textarea cols="15" rows="5" id="comments" name="comments">{{$request->comments}}</textarea>
                                @else
                                    <textarea cols="15" rows="5" id="comments" name="comments">{{old('comments')}}</textarea>
                                @endif
                                @error('comments')
                                    <ul style="clear: both">
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
                        @if (isset($afterschool))
                            <input type="hidden" name="commentableId" value="{{ $afterschool->id }}">
                            <input type="hidden" name="commentableType" value="afterschool">
                        @else
                            <input type="hidden" name="commentableId" value="{{ $activity->id }}">
                            <input type="hidden" name="commentableType" value="activity">
                        @endif
                        
                        <tr id="submit-element">
                            <td></td>
                            <td>
                                <input type="submit" name="submit" class="btn" value="Add Review">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        @endif
    </div>
@endsection
