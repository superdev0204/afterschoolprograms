@push('title')
    <title>Verify Email Address | Review</title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/">Home</a> &gt;&gt; Verify your review for:

        <h2>Verify your review for:</h2>

        <?php if (isset($activity)): ?>
        <?php echo $activity->name; ?><br />
        <?php echo $activity->address . ' ' . $activity->city . ' ' . $activity->state . ' ' . $activity->zip; ?><br />
        <?php else: ?>
        <?php echo $afterschool->name; ?><br />
        <?php echo $afterschool->address . ' ' . $afterschool->city . ' ' . $afterschool->state . ' ' . $afterschool->zip; ?><br />
        <?php endif; ?>

        <p>
            Thank you for verify your email address. Your comment will be reviewed for approval within 1-2 business
            days.<br />

            <?php if (isset($activity)): ?>
            <a href="">Return to listing details</a>
            <?php else: ?>
            <a href="/program-<?php echo $afterschool->id; ?>-<?php echo $afterschool->filename; ?>.html">Return to listing details</a>
            <?php endif; ?>
        </p>
    </div>

    <div id="right-col">
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
