@push('meta')
    <meta name="description"
        content="{{ $afterschool->name . ' is an after school afterschool in ' . ucwords(strtolower($city->city)) . ' ' . $city->state }}">
@endpush

@push('title')
    <title>{{ $afterschool->name . ' | ' . ucwords(strtolower($city->city)) . ' ' . $city->state }} After School Program
    </title>
@endpush

@extends('layouts.app')

@section('content')
    <script src="//maps.google.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}"></script>
    <script src="{{ asset('js/tiny_mce/tiny_mce.js') }}"></script>
    <script src="{{ asset('js/tiny_mce/tiny_mce_activate.js') }}"></script>

    <div id="left-col">
        <a href="/<?php echo $state->statefile; ?>_activities.html"><?php echo $state->state_name; ?> After School Programs</a> &gt;&gt;
        <a href="/<?php echo $state->statefile; ?>-city/<?php echo $city->filename; ?>-care.html"><?php echo ucwords(strtolower($city->city)); ?> After School Care</a> &gt;&gt;
        <?php echo ucwords(strtolower($afterschool->name)); ?>
        <div>
            <h2><?php echo $afterschool->name . ', ' . $afterschool->city . ' ' . $afterschool->state; ?> </h2>
        </div>

        Program Name: <b><?php echo $afterschool->name . ($afterschool->location ? ' - ' . $afterschool->location : ''); ?></b><br />
        Program Address: <?php echo $afterschool->address . ', ' . $afterschool->city . ' ' . $afterschool->state . ' ' . $afterschool->zip; ?><br />
        Contact Phone: <?php echo $afterschool->phone; ?><br>
        <?php if($afterschool->website <> ""):?>
        Website: <?php echo $afterschool->website; ?><br />
        <?php endif;?>
        <?php if($afterschool->introduction <> ""):?>
        Detail: <?php echo $afterschool->introduction; ?><br />
        <?php endif;?>

        <table>
            <tr>
                <td>
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins class="adsbygoogle" style="display:inline-block;width:336px;height:280px"
                        data-ad-client="ca-pub-8651736830870146" data-ad-slot="9653404904"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </td>
                <td>
                    <div id="map_canvas" style="width: 330px; height: 280px">
                        <?php if ($afterschool->lat && $afterschool->lng): ?>
                            <iframe src="https://maps.google.com/maps?q={{ $afterschool->address }}, {{ $afterschool->city }}, {{ $afterschool->state }} {{ $afterschool->zip }}&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                                frameborder="0" scrolling="no" style="width: 100%; height: 100%;"></iframe>
                        <?php endif;?>
                    </div>
                </td>
            </tr>
        </table>
        <?php if(count($images)>0) : ?>
        <div> <strong><?php echo $afterschool->name; ?> Photos:</strong> (Click to enlarge)<br />
            <?php
            /** @var \Application\Domain\Entity\Image $image */
            foreach ($images as $image): ?>
            <?php if ($image->image_name != '' && file_exists(public_path() . '/images/afterschool/' . $image->imageable_id . '/' . $image->image_name) ) : ?>
            <a href="<?php echo public_path() . '/images/afterschool/' . $image->imageable_id . '/' . $image->image_name; ?>" rel="lightbox[roadtrip]"> <img src="<?php echo public_path() . '/images/afterschool/' . $image->imageable_id . '/' . $image->image_name; ?>" border="0"
                    width="150" height="150" alt="<?php echo $image->altname; ?>" /> </a>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <br />
        <?php endif;?>

        <?php if(count($reviews)>0) : ?>
        Reviews: There are <?php echo count($reviews); ?> reviews for this provider.
        <div align="center">
            <table width="90%">
                <?php
                /** @var \Application\Domain\Entity\Review $review */
                foreach ($reviews as $review): ?>
                <tr>
                    <td colspan="2"> Rated <?php echo $review->rating; ?> star by <?php echo $review->review_by; ?> on <?php echo $review->review_date; ?></td>
                </tr>
                <tr>
                    <td>Comment:</td>
                    <td><?php echo stripslashes($review->comments); ?></td>
                </tr>
                <?php endforeach;?>
            </table>
        </div>
        Share your experience by <a href="#review">review </a>this childcare provider.
        <?php else : ?>
        Reviews: Be the first to <a href="#review">review </a>this childcare provider.
        <?php endif; ?>

        <p>
            <a name="review"></a>Share your experience with <?php echo ucwords(strtolower($afterschool->name)); ?>, whether your child attended, you
            evaluated their services, or you worked there. You can help others by writing a review.
        </p>
        <br>

        <form method="post" action="/review/new">
            @csrf
            <table width="100%">
                <tbody>
                    <tr>
                        <td><label class="required" for="email">Email address (will not be published):</label></td>
                        <td>
                            <input type="email" name="email" class="form-textbox" value="">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="required" for="reviewBy">Display Name:</label></td>
                        <td>
                            <input name="reviewBy" type="text" class="form-textbox" value="">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="required" for="rating">Rating (1=poor, 5=exellent):</label></td>
                        <td>
                            <select name="rating" class="form-selectbox">
                                <option value="">Select Your Rating</option>
                                <option value="1">Review - 1 star</option>
                                <option value="2">Review - 2 star</option>
                                <option value="3">Review - 3 star</option>
                                <option value="4">Review - 4 star</option>
                                <option value="5">Review - 5 star</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="required" for="comments">Write your comment:</label></td>
                        <td>
                            <textarea name="comments" cols="15" rows="5" id="comments"></textarea>
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
                    <input type="hidden" name="commentableId" value="{{ $afterschool->id }}">
                    <input type="hidden" name="commentableType" value="afterschool">
                    <tr id="submit-element">
                        <td></td>
                        <td>
                            <input type="submit" name="submit" class="btn" value="Add Review">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>

        <style>
            .question_section{
                width:100%!important;
            }
            .question-title{
                margin:auto!important;
                float:none!important;
            }
            .question-wrapper{
                width:100%!important
            }
            .single-question{
                padding: 20px!important
            }
            .answer{
                padding-left:20px!important;
                clear: both
            }
            .reply{
                clear: both;
            }
            .ask-question-btn{
                clear: both;
            }
            .ask-question-btn{
                margin:auto!important;
                float:none!important;
            }
            .answer-btn{
                float:right!important;
            }
        </style>
        <div class="question_section ">
            <div class="question-title">
                <h2 class="black-title">Ask the Community</h2>
                <p>Connect, Seek Advice, Share Knowledge</p>
            </div>
            <div class="ask-question-btn">
                <input type="button" class="btn" value="Ask a Question" onclick="window.location.href='/send_question?id={{ $afterschool->id }}&type=afterschool'" />
            </div>
            <div class="question-wrapper">
                @foreach ($questions as $question)
                    <div class="single-question clinic_table">
                        <div class="question">
                            <p>Question by {{ $question->question_by }} ({{ $question->passed }} ago): <?php echo $question->question;?></p>
                        </div>
                        @foreach ($question->answers as $answer)
                            <div class="answer">
                                <p>Answer: <?php echo $answer->answer;?></p>
                            </div>
                        @endforeach
                        <div class="answer-btn">
                            <input type="button" class="btn" value="Answer the Question Above" onclick="window.location.href='/send_answer?id={{$afterschool->id}}&type=afterschool&questionId={{$question->id}}'" />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="right-col">
        {{-- <?php if($afterschool->claim == '0' || (isset($user->type) && $afterschool->user_id == $user->id)):?>
        <input type="button" id="edit_btn" name="edit_btn" class="btn" value="Edit"
            onclick="window.location.href='/program/edit/id/<?php echo $afterschool->id; ?>'" />
        <?php endif;?> --}}
        <h3>Notes</h3><br/>
        <span>Are you the owner or director of this program?</span><br/><br/>
        <a href="/program/edit/id/<?php echo $afterschool->id; ?>" style="display:unset; padding:5px">Update Afterschool Information</a><br/><br/>
        <span>If you notice any inaccurate information on this page, please let us know so we can correct.</span><br/><br/>
        <a href="/contact?id=<?php echo $afterschool->id; ?>&type=afterschool" style="display:unset; padding:5px">Report Incorrect Information</a><br/><br/>
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
            <a class="addthis_button_preferred_1"></a>
            <a class="addthis_button_preferred_2"></a>
            <a class="addthis_button_preferred_3"></a>
            <a class="addthis_button_preferred_4"></a>
            <a class="addthis_button_compact"></a>
            <a class="addthis_counter addthis_bubble_style"></a>
        </div>
        <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js#pubid=childcarecenter"></script>
        <!-- AddThis Button END --><br />
        <div class="widget">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- Afterschool Program Responsive -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-8651736830870146"
                data-ad-slot="6918622775" data-ad-format="auto"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
@endsection
