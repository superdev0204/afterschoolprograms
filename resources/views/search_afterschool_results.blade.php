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
            foreach ($afterschools as $afterschool): $i++; ?>
            <tr>
                <td valign="top">
                    <a target="_blank"
                        href="/program-<?php echo $afterschool->id; ?>-<?php echo $afterschool->filename; ?>.html"><strong><?php echo ucwords(strtolower($afterschool->name)); ?></strong></a><br />
                    <strong>Location:</strong> <?php echo ucwords(strtolower($afterschool->city)) . ', ' . $afterschool->state . ' - ' . $afterschool->zip; ?> <br />
                    <strong>Contact Phone</strong>: <?php echo $afterschool->phone; ?><br />
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
@endsection
