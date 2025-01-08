@push('title')
    <title>Search</title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/">Home</a> &gt;&gt; Search
        <h2>Search Result</h2>

        <p><?php echo $message; ?></p>

        <table width="100%" class="widgetized">
            <?php
            $i=0;
            /** @var \Application\Domain\Entity\Afterschool $afterschool */
            foreach ($activities as $activity): $i++; ?>
            <tr>
                <td valign="top">
                    <a target="_blank" href="/<?php echo $activity->category == 'MARTIAL-ARTS' ? 'activity' : 'sportclub'?>-<?php echo $activity->id ?>-<?php echo $activity->filename ?>.html"><strong><?php echo ucwords(strtolower($activity->name)) ?></strong></a><br/>
                    <strong>Location:</strong> <?php echo ucwords(strtolower($activity->city)) . ", " . $activity->state . " - " . $activity->zip ?> <br />
                    <strong>Contact Phone</strong>: <?php echo $activity->phone ?><br/>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
@endsection
