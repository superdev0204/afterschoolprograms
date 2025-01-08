@push('meta')
    <meta name="description"
        content="Complete listing of after school programs in {{ ucwords(strtolower($city->city)) }} {{ $city->state }}">
@endpush

@push('title')
    <title>
        {{ ucwords(strtolower($city->city)) . ', ' . $city->state . ' After School Care | Afterschool Programs in ' . ucwords(strtolower($city->city)) . ' ' . $city->state }}
    </title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/">After School Programs</a> &gt;&gt;
        <a href="/<?php echo $state->statefile; ?>_activities.html"><?php echo $state->state_name; ?> After School</a> &gt;&gt;
        <?php echo ucwords(strtolower($city->city)); ?> After School Care<br />
        <h2><?php echo ucwords(strtolower($city->city)); ?> After School Care Programs </h2><br />
        <p>Below is the current after school care listing we have in <?php echo ucwords(strtolower($city->city)); ?>.</p>

        <div id="adcontainer1"></div>
        <script src="//www.google.com/adsense/search/ads.js" type="text/javascript"></script>
        <script type="text/javascript" charset="utf-8">
            var pageOptions = {
                'pubId': 'pub-8651736830870146',
                'query': '<?php $randomString = ['afterschool', 'summer camp', 'tutoring', 'after school'];
                echo strtolower($city->city) . ' ' . $randomString[rand(0, 3)]; ?>',
                'channel': '6316377572',
                'hl': 'en'
            };

            var adblock1 = {
                'container': 'adcontainer1',
                'width': '420px',
                'colorTitleLink': '215C97'
            };

            new google.ads.search.Ads(pageOptions, adblock1);
        </script>

        <?php
        /** @var \Application\Domain\Entity\Afterschool $afterschool */
        foreach ($afterschools as $afterschool): ?>
        <p><a href="/program-<?php echo $afterschool->id . '-' . $afterschool->filename; ?>.html"><?php echo $afterschool->name . ($afterschool->location ? ' - ' . $afterschool->location : ''); ?></a>
            <br /><?php echo $afterschool->address . ', ' . $afterschool->city . ' ' . $afterschool->state . ' - ' . $afterschool->phone; ?>
        </p>
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
                <input type="button" class="btn" value="Ask a Question" onclick="window.location.href='/send_question?page_url={{ $page_url }}&type=afterschool'" />
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
                            <input type="button" class="btn" value="Answer the Question Above" onclick="window.location.href='/send_answer?page_url={{ $page_url }}&type=afterschool&questionId={{$question->id}}'" />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="right-col">
        <div class="widget">
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                <a class="addthis_button_preferred_1"></a>
                <a class="addthis_button_preferred_2"></a>
                <a class="addthis_button_preferred_3"></a>
                <a class="addthis_button_preferred_4"></a>
                <a class="addthis_button_compact"></a>
                <a class="addthis_counter addthis_bubble_style"></a>
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- AfterschoolProgram All Pages Adlinks -->
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-8651736830870146"
                    data-ad-slot="1809619174" data-ad-format="link"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=childcarecenter"></script><br />
            <!-- AddThis Button END -->
            <iframe
                src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fafterschoolprograms&amp;width=300&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false&amp;appId=155446947822305"
                scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:258px;"
                allowTransparency="true"></iframe>
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px"
                data-ad-client="ca-pub-8651736830870146" data-ad-slot="5507651968"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
@endsection
