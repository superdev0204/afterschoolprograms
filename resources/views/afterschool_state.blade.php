@push('title')
    <title>{{ $state->state_name }} After School Programs | {{ $state->state_name }} Summer Camps and After School Care
    </title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/">After School Programs</a> &gt;&gt;
        <?php echo $state->state_name; ?> After School Care <br />
        <h2><?php echo $state->state_name; ?> After School Programs </h2>
        <p>Are you looking for after school programs in the <?php echo $state->state_name; ?> area?
            Simply pick the city that is closest to your particular locale, and you'll be able to look through a listing of
            after school programs and summer camps in that city.
            You'll be surprised at the wide variety of after school programs that we have on offer - it's much easier to
            find what you are looking for when there is a list of programs in the same place to choose from.
            Check out the many different after school and summer camp offerings in <?php echo $state->state_name; ?> - your children will
            thank you!</p>
        <p>We currently have after school care listing for cities below. We will have more data soon.</p>

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
            $i = 0; $recordCount = ceil(count($cities)/3);
            /** @var \Application\Domain\Entity\City $city */
            foreach ($cities as $city): $i++;?>
                <?php
                if ($city->afterschool_count > 0): ?>
                <li><a href="/<?php echo $state->statefile; ?>-city/<?php echo $city->filename; ?>-care.html"><?php echo ucwords(strtolower($city->city)); ?></a>
                    (<?php echo $city->afterschool_count; ?>)<br /></li>
                <?php endif; ?>
                <?php endforeach;?>
            </ul>
        </div>

        <h2>Latest Update to After School Programs database: </h2>
        <table>
            <?php
        /** @var \Application\Domain\Entity\Afterschool $afterschool */
        foreach ($afterschools as $afterschool): ?>
            <tr>
                <td width="30%" valign="top">
                    <a href="/program-<?php echo $afterschool->id . '-' . $afterschool->filename; ?>.html"><?php echo $afterschool->name; ?></a> - <?php echo $afterschool->address . ', ' . $afterschool->city . ' ' . $afterschool->state . ' - ' . $afterschool->phone; ?> <br />
                </td>
                <td valign="top">
                    <?php echo $afterschool->introduction; ?>
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
