@push('title')
    <title>{{ ucwords(strtolower($city->city)) }}, {{ $city->state }} Youth Sports | Soccer, Football, and Softball Clubs
        in {{ ucwords(strtolower($city->city)) }} {{ $city->state }}| After School Programs</title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/youth-sports">Youth Sports</a> &gt;&gt;
        <a href="/<?php echo $state->statefile; ?>_youth-sports.html"><?php echo $state->state_name; ?> Youth Sport Clubs</a> &gt;&gt;
        <?php echo ucwords(strtolower($city->city)); ?> After School Sports<br />
        <h2><?php echo ucwords(strtolower($city->city)); ?> After School Youth Sport Clubs</h2><br />

        <p>Below are after school youth sports available in <?php echo ucwords(strtolower($city->city)); ?>.</p>

        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Afterschool Program Responsive -->
        <style type="text/css">
            .adslot_2 {
                display: inline-block;
                width: 580px;
                height: 400px;
            }

            @media (max-width:600px) {
                .adslot_2 {
                    width: 336px;
                    height: 280px;
                }
            }
        </style>
        <ins class="adsbygoogle adslot_2" style="display:block" data-ad-client="ca-pub-8651736830870146"
            data-ad-slot="6918622775"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

        <?php
    /** @var \Application\Domain\Entity\Activity $activity */
    foreach ($activities as $activity): ?>
        <a href="/sportclub-<?php echo $activity->id; ?>-<?php echo $activity->filename; ?>.html"><?php echo $activity->name; ?></a> - <?php echo $activity->address . ', ' . $activity->city . ' ' . $activity->state . ' - ' . $activity->phone; ?>
        <br />
        <?php if($activity->details <> "") :?>
        <strong>Details</strong>: <?php echo substr(strip_tags($activity->details), 0, 240); ?>...<a
            href="/sportclub-<?php echo $activity->id; ?>-<?php echo $activity->filename; ?>.html">more</a><br />
        <?php endif;?><br />
        <?php endforeach;?>

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
        <div class="question_section">
            <div class="question-title">
                <h2 class="black-title">Ask the Community</h2>
                <p>Connect, Seek Advice, Share Knowledge</p>
            </div>
            <div class="ask-question-btn">
                <input type="button" class="btn" value="Ask a Question" onclick="window.location.href='/send_question?page_url={{ $page_url }}&type=youth_sports'" />
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
                            <input type="button" class="btn" value="Answer the Question Above" onclick="window.location.href='/send_answer?page_url={{ $page_url }}&type=youth_sports&questionId={{$question->id}}'" />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="right-col">
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

            <div id="adcontainer1"></div>
            <script src="//www.google.com/adsense/search/ads.js" type="text/javascript"></script>
            <script type="text/javascript" charset="utf-8">
                var pageOptions = {
                    'pubId': 'pub-8651736830870146',
                    'query': '<?php $randomString = ['youth soccer', 'girl softballs', 'kid soccer clubs', 'after school sport'];
                    echo strtolower($city->city) . ' ' . $randomString[rand(0, 3)]; ?>',
                    'channel': '7437350373',
                    'hl': 'en'
                };

                var adblock1 = {
                    'container': 'adcontainer1',
                    'width': '310px',
                    'colorTitleLink': '215C97'
                };

                new google.ads.search.Ads(pageOptions, adblock1);
            </script>
        </div>
    </div>
@endsection
