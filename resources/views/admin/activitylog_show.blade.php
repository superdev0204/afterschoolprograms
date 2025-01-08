@extends('layouts.app_admin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Activity Update Compare</li>
        </ol>
    </nav>
    <a target="_blank" href="/<?php echo optional(optional($activityLog)->activity)->category == 'MARTIAL-ARTS' ? 'activity' : 'sportclub'?>-<?php echo optional(optional($activityLog)->activity)->id ?>.html"><?php echo optional(optional($activityLog)->activity)->name ?></a>
    <table class="table">
        <tr>
            <th>Field Name</th>
            <th>Old</th>
            <th>New</th>
        </tr>
        <?php
            foreach ($activityLog->getEditableFields() as $field => $title):
                if ($activityLog->$field == $activityLog->activity->$field) continue;
            ?>
            <tr class="d0">
                <td style="width: 20%"><?php echo $title; ?></td>
                <td style="width: 40%">
                    <?php echo $activityLog->activity->$field; ?>
                </td>
                <td style="width: 40%">
                    <?php echo $activityLog->$field; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="text-align: left">
                <form method="post" action="/admin/activity-log/approve" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $activityLog->id; ?> " />
                    <input type="submit" class="btn btn-success" value="Approve" />
                </form>
                <form method="post" action="/admin/activity-log/disapprove" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $activityLog->id; ?> " />
                    <input type="submit" class="btn btn-warning" value="Not Approve" />
                </form>
                <form method="post" action="/admin/activity-log/delete" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $activityLog->id; ?> " />
                    <input type="submit" class="btn btn-danger" value="Delete" />
                </form>
            </td>
        </tr>
    </table>
@endsection
