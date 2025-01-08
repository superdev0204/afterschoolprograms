@push('title')
    <title>Youth Sports | Youth Soccer, Football, Softball Clubs| After School Activities | After School Programs</title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <h2>Find Youth Soccer, Football, Softball Clubs</h2>
        <p>
            This is a directory of youth sport clubs in the US, including youth soccer, football, softball, etc...
            If you are a coach, you can add your club at <a href="https://afterschoolprograms.us/youth-sports/new">https://afterschoolprograms.us/youth-sports/new</a>
        </p>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Afterschool Program Responsive -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-8651736830870146" data-ad-slot="6918622775"
            data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <h2>Bse by State</h2>
        <div class="states">
            <ul>
                <?php
                /** @var \Application\Domain\Entity\State $state */
                foreach ($states as $state): ?>
                <li><a href="/<?php echo $state->statefile; ?>_youth-sports.html"><?php echo $state->state_name; ?></a></li>
                <?php endforeach;?>
            </ul>
            <div class="clear"></div>
        </div>
        <div align="center">
            <img src="/images/usa-map.jpg" class="img-reponsive" border="0" usemap="#usmap"
                alt="Map of Youth Sport Clubs in the United States" />
            <map name="usmap" id="usmap">
                <area shape="poly" coords="94,76,127,85,118,118,157,181,147,200,126,195,101,166,90,118,88,94"
                    href="/california_youth-sports.html" title="California After School Programs">
                <area shape="poly" coords="70,137,111,207,63,188,10,215,25,139,42,129" href="/alaska_youth-sports.html"
                    title="Alaska After School Programs">
                <area shape="poly" coords="151,92,95,76,111,31,119,41,140,45,161,48" href="/oregon_youth-sports.html"
                    title="Oregon After School Programs">
                <area shape="poly" coords="130,5,168,15,160,47,121,39,112,28,112,7" href="/washington_youth-sports.html"
                    title="Washington After School Programs">
                <area shape="poly" coords="154,173,161,162,176,97,150,93,128,87,120,117" href="/nevada_youth-sports.html"
                    title="Nevada After School Programs">
                <area shape="poly" coords="199,100,204,73,189,71,183,48,176,19,169,17,154,91"
                    href="/idaho_youth-sports.html" title="Idaho After School Programs">
                <area shape="poly" coords="177,99,198,102,197,113,214,116,207,160,165,152" href="/utah_youth-sports.html"
                    title="Utah After School Programs">
                <area shape="poly" coords="69,221,141,260,168,290,145,304,125,265,87,245,63,232"
                    href="/hawaii_youth-sports.html" title="Hawaii After School Programs">
                <area shape="poly" coords="165,155,206,162,196,222,180,221,150,201,161,182,158,174"
                    href="/arizona_youth-sports.html" title="Arizona After School Programs">
                <area shape="poly" coords="180,19,191,69,203,71,205,65,260,74,264,32" href="/montana_youth-sports.html"
                    title="Montana After School Programs">
                <area shape="poly" coords="207,70,200,111,255,118,259,77" href="/wyoming_youth-sports.html"
                    title="Wyoming After School Programs">
                <area shape="poly" coords="216,117,273,123,269,165,210,159" href="/colorado_youth-sports.html"
                    title="Colorado After School Programs">
                <area shape="poly" coords="210,163,201,222,220,218,255,221,259,168" href="/new_mexico_youth-sports.html"
                    title="New Mexico After School Programs">
                <area shape="poly" coords="267,34,265,63,319,66,316,35" href="/north_dakota_youth-sports.html"
                    title="North Dakota After School Programs">
                <area shape="poly" coords="264,66,261,97,320,103,320,71" href="/south_dakota_youth-sports.html"
                    title="South Dakota After School Programs">
                <area shape="poly" coords="262,101,260,118,276,120,276,131,328,134,319,107"
                    href="/nebraska_youth-sports.html" title="Nebraska After School Programs">
                <area shape="poly" coords="275,135,273,165,336,168,331,137" href="/kansas_youth-sports.html"
                    title="Kansas After School Programs">
                <area shape="poly" coords="263,168,262,173,288,175,289,194,320,205,338,207,335,170"
                    href="/oklahoma_youth-sports.html" title="Oklahoma After School Programs">
                <area shape="poly"
                    coords="262,175,287,177,287,196,322,208,341,210,347,238,343,252,320,265,309,279,311,292,288,276,265,248,252,255,237,238,224,222,258,224"
                    href="/texas_youth-sports.html" title="Texas After School Programs">
                <area shape="poly" coords="347,251,351,237,345,216,368,215,370,223,365,235,382,237,390,256"
                    href="/louisiana_youth-sports.html" title="Louisiana After School Programs">
                <area shape="poly" coords="319,35,323,72,323,95,364,95,352,82,355,64,358,54,373,45,336,34"
                    href="/minnesota_youth-sports.html" title="Minnesota After School Programs">
                <area shape="poly" coords="323,97,363,97,373,111,364,127,329,128,324,110" href="/iowa_youth-sports.html"
                    title="Iowa After School Programs">
                <area shape="poly" coords="337,132,361,131,385,168,381,178,376,175,339,175,336,143"
                    href="/missouri_youth-sports.html" title="Missouri After School Programs">
                <area shape="poly" coords="338,177,379,179,375,192,368,205,368,213,344,214,340,204"
                    href="/arkansas_youth-sports.html" title="Arkansas After School Programs">
                <area shape="poly" coords="372,59,387,50,419,61,433,83,438,95,432,108,404,111,404,82,395,71"
                    href="/michigan_youth-sports.html" title="Michigan After School Programs">
                <area shape="poly" coords="357,61,355,81,367,95,373,106,392,105,391,98,396,76,381,66,370,61"
                    href="/wisconsin_youth-sports.html" title="Wisconsin After School Programs">
                <area shape="poly" coords="374,108,393,108,396,116,398,147,394,157,392,165,385,166,365,131"
                    href="/illinois_youth-sports.html" title="Illinois After School Programs">
                <area shape="poly" coords="398,116,403,113,418,112,422,143,412,153,396,156,401,147"
                    href="/indiana_youth-sports.html" title="Indiana After School Programs">
                <area shape="poly" coords="420,112,431,110,438,113,452,105,456,120,444,144,423,140"
                    href="/ohio_youth-sports.html" title="Ohio After School Programs">
                <area shape="poly" coords="385,173,440,166,448,157,441,145,425,143,415,156,396,159"
                    href="/kentucky_youth-sports.html" title="Kentucky After School Programs">
                <area shape="poly" coords="379,190,431,186,453,166,384,175" href="/tennessee_youth-sports.html"
                    title="Tennessee After School Programs">
                <area shape="poly" coords="376,193,396,191,398,240,387,243,385,236,368,234,374,223,371,207"
                    href="/mississippi_youth-sports.html" title="Mississippi After School Programs">
                <area shape="poly" coords="399,192,419,190,429,232,406,234,406,241,400,241"
                    href="/alabama_youth-sports.html" title="Alabama After School Programs">
                <area shape="poly"
                    coords="407,235,429,233,432,236,464,233,485,274,483,292,463,273,455,251,444,242,429,245,416,240,408,240"
                    href="/florida_youth-sports.html" title="Florida After School Programs">
                <area shape="poly" coords="422,189,442,187,467,216,462,231,433,235" href="/georgia_youth-sports.html"
                    title="Georgia After School Programs">
                <area shape="poly" coords="455,166,504,157,511,169,488,191,476,182,465,183,460,178,442,184,435,185"
                    href="/north_carolina_youth-sports.html" title="North Carolina After School Programs">
                <area shape="poly" coords="447,189,469,214,485,193,473,184,466,185,459,182,450,184"
                    href="/south_carolina_youth-sports.html" title="South Carolina After School Programs">
                <area shape="poly"
                    coords="448,158,444,165,503,155,496,142,488,139,488,134,480,132,473,142,465,154,455,158"
                    href="/virginia_youth-sports.html" title="Virginia After School Programs">
                <area shape="poly" coords="504,141,502,149,518,159,529,157,530,149"
                    href="/district_of_columbia_youth-sports.html" title="Washington DC After School Programs">
                <area shape="poly" coords="455,105,459,127,500,121,505,116,502,102,496,97"
                    href="/pennsylvania_youth-sports.html" title="Pennsylvania After School Programs">
                <area shape="poly" coords="462,101,498,95,512,104,504,62,493,63,487,80,479,86,466,88"
                    href="/new_york_youth-sports.html" title="New York After School Programs">
                <area shape="poly" coords="507,61,519,57,520,62,518,65,518,82,512,83" href="/vermont_youth-sports.html"
                    title="Vermont After School Programs">
                <area shape="poly" coords="523,81,531,77,521,53,522,61,520,66,520,74"
                    href="/new_hampshire_youth-sports.html" title="New Hampshire After School Programs">
                <area shape="poly" coords="524,54,532,73,554,49,543,27,537,24,530,26,527,34"
                    href="/maine_youth-sports.html" title="Maine After School Programs">
                <area shape="poly" coords="513,84,537,77,555,78,555,85,534,92,529,87,513,90"
                    href="/massachusetts_youth-sports.html" title="Massachusetts After School Programs">
                <area shape="poly" coords="526,89,528,96,546,107,554,106,553,95,535,93,529,89"
                    href="/rhode_island_youth-sports.html" title="Rhode Island After School Programs">
                <area shape="poly" coords="512,93,524,90,526,97,543,108,532,111,521,99,516,102"
                    href="/connecticut_youth-sports.html" title="Connecticut After School Programs">
                <area shape="poly" coords="534,135,534,146,507,140,490,137,482,127,498,126,502,135,507,137"
                    href="/maryland_youth-sports.html" title="Maryland After School Programs">
                <area shape="poly"
                    coords="504,103,511,107,514,113,532,114,532,121,520,121,513,121,510,126,502,123,508,116,505,110"
                    href="/new_jersey_youth-sports.html" title="New Jersey After School Programs">
                <area shape="poly" coords="503,135,532,133,531,123,509,129,503,129,500,123,498,129"
                    href="/delaware_youth-sports.html" title="Delaware After School Programs">
                <area shape="poly" coords="445,146,455,127,460,131,478,127,481,130,472,142,465,151,451,157"
                    href="/west_virginia_youth-sports.html" title="West Virginia After School Programs">
            </map>
        </div>
        <h2>Latest Update to Youth Sports database: </h2>
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
                    <?php echo $activity->details; ?>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
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
