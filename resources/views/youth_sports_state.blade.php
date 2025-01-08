@push('title')
    <title>{{ $state->state_name }} Youth Sports | Soccer, Football, Softball Clubs in {{ $state->state_name }} |
        After School Programs</title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/youth-sports">Youth Sports</a> &gt;&gt;
        <?php echo $state->state_name; ?> Soccer Football Softball Clubs<br />
        <h2><?php echo $state->state_name; ?> After School Youth Sports</h2>
        <p>Click on the city below for listings of youth soccer, football, and softball clubs in that city.</p>

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

        <div class="cities">
            <ul>
                <?php 
            $i = 0; 
            $recordCount = ceil(count($cities)/3); 
            
            /** @var \Application\Domain\Entity\City $city */
            foreach ($cities as $city): ?>
                <?php $i++; if ($city->sports_count > 0) : ?>
                <li><a href="/<?php echo $state->statefile; ?>-youth-sports/<?php echo $city->filename; ?>.html"><?php echo ucwords(strtolower($city->city)); ?></a>
                    (<?php echo $city->sports_count; ?>)</li>
                <?php endif; ?>
                <?php endforeach;?>
            </ul>
        </div>

        <h2>New addition to <?php echo $state->state_name; ?> Youth Sports database: </h2>
        <table>
            <?php
        /** @var \Application\Domain\Entity\Activity $activity */
        foreach ($activities as $activity): ?>
            <tr>
                <td width="30%" valign="top">
                    <a href="/sportclub-<?php echo $activity->id; ?>-<?php echo $activity->filename; ?>.html"><?php echo $activity->name; ?></a> -
                    <?php echo $activity->address . ', ' . $activity->city . ' ' . $activity->state . ' - ' . $activity->phone; ?> <br />
                </td>
                <td valign="top">
                    <?php echo substr(strip_tags($activity->details), 0, 240); ?>...<a href="">more</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>

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

            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- AfterschoolProgram All Pages Adlinks -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-8651736830870146"
                data-ad-slot="1809619174" data-ad-format="link"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>

        </div>
        <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js#pubid=childcarecenter"></script>
        <!-- AddThis Button END --><br />
        <iframe
            src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fafterschoolprograms&amp;width=300&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false&amp;appId=155446947822305"
            scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:258px;"
            allowTransparency="true"></iframe>
        <div class="widget">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px"
                data-ad-client="ca-pub-8651736830870146" data-ad-slot="5507651968"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
@endsection
