@extends('layouts.app_admin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
    <h3 class="page-header">New Afterschool Listings</h3>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th colspan="4" align="activity">Action</th>
        </tr>
        <?php
        /** @var \Application\Domain\Entity\Afterschool $afterschool */
        foreach ($afterschools as $afterschool): ?>
        <tr>
            <td width="30%">
                <a target="_blank" href="/program-<?php echo $afterschool->id; ?>-<?php echo $afterschool->filename; ?>.html"><?php echo $afterschool->name; ?></a><br />
                <?php echo $afterschool->phone; ?>
            </td>
            <td width="30%">
                <?php echo $afterschool->address; ?><br />
                <?php echo $afterschool->city . ', ' . $afterschool->state . ' ' . $afterschool->zip; ?>
            </td>
            <td>
                <form method="post" action="/admin/afterschool/approve">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $afterschool->id; ?>" />
                    <input type="submit" class="btn btn-success" value="Approve" />
                </form>
            </td>
            <td>
                <form method="post" action="/admin/afterschool/disapprove">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $afterschool->id; ?>" />
                    <input type="submit" class="btn btn-warning" value="Not Approve" />
                </form>
            </td>
            <td>
                <form method="get" action="/admin/afterschool/edit">
                    <input type="hidden" name="id" value="<?php echo $afterschool->id; ?>" />
                    <input type="submit" class="btn btn-info" value="Update" />
                </form>
            </td>
            <td>
                <form method="post" action="/admin/afterschool/delete">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $afterschool->id; ?>" />
                    <input type="submit" class="btn btn-danger" value="Delete" />
                </form>
            </td>
        </tr>
        <?php endforeach;?>
    </table><br />

    <h3 class="page-header">New Activity Listings</h3>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th colspan="4" align="activity">Action</th>
        </tr>
        <?php
    /** @var \Application\Domain\Entity\Activity $activity */
    foreach ($activities as $activity): ?>
        <tr>
            <td width="30%">
                <a target="_blank"
                    href="/<?php echo $activity->category == 'MARTIAL-ARTS' ? 'activity' : 'sportclub'; ?>-<?php echo $activity->id; ?>-<?php echo $activity->filename; ?>.html"><?php echo $activity->name; ?></a><br />
                <?php echo $activity->phone; ?>
            </td>
            <td width="30%">
                <?php echo $activity->address; ?><br />
                <?php echo $activity->city . ', ' . $activity->state . ' ' . $activity->zip; ?>
            </td>
            <td>
                <form method="post" action="/admin/activity/approve">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $activity->id; ?>" />
                    <input type="submit" class="btn btn-success" value="Approve" />
                </form>
            </td>
            <td>
                <form method="post" action="/admin/activity/disapprove">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $activity->id; ?>" />
                    <input type="submit" class="btn btn-warning" value="Not Approve" />
                </form>
            </td>
            <td>
                <form method="get" action="/admin/activity/edit">
                    <input type="hidden" name="id" value="<?php echo $activity->id; ?>" />
                    <input type="submit" class="btn btn-info" value="Update" />
                </form>
            </td>
            <td>
                <form method="post" action="/admin/activity/delete">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $activity->id; ?>" />
                    <input type="submit" class="btn btn-danger" value="Delete" />
                </form>
            </td>
        </tr>
        <?php endforeach;?>
    </table><br />

    <h3 class="page-header">New Afterschool Updates</h3>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
        </tr>
        <?php
        /** @var  \Application\Domain\Entity\AfterschoolLog $afterschoolLog */
        foreach ($afterschoolLogs as $afterschoolLog):
            // if (!$afterschoolLog->hasChanges()) continue;
        ?>
        <tr>
            <td width="40%">
                <a href="/admin/afterschool-log/show/id/<?php echo $afterschoolLog->id; ?>"><?php echo $afterschoolLog->name; ?></a>
            </td>
            <td>
                <?php echo $afterschoolLog->address; ?>
            </td>
            <td>
                <?php echo $afterschoolLog->phone; ?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>

    <h3 class="page-header">New Activity Updates</h3>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
        </tr>
        <?php
        /** @var  \Application\Domain\Entity\ActivityLog $activityLog */
        foreach ($activityLogs as $activityLog):
            // if (!$activityLog->hasChanges()) continue;
        ?>
        <tr>
            <td width="40%">
                <a href="/admin/activity-log/show/id/<?php echo $activityLog->id; ?>"><?php echo $activityLog->name; ?></a>
            </td>
            <td>
                <?php echo $activityLog->address; ?>
            </td>
            <td>
                <?php echo $activityLog->phone; ?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>

    <h3 class="page-header">New Images</h3>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Image</th>
            <th align="activity" colspan="3">Action</th>
        </tr>
        <?php
        /** @var \Application\Domain\Entity\Image $image */
        foreach ($images as $image):
        ?>
        <tr>
            <td width="35%">
                <?php if ($image->imageable_type == 'activity'): ?>
                <a target="_blank"
                    href="/<?php echo $image->activity_category == 'MARTIAL-ARTS' ? 'activity' : 'sportclub'; ?>-<?php echo $image->activity_id; ?>-<?php echo $image->activity_filename; ?>.html"><?php echo $image->imagename; ?></a><br />
                <?php else: ?>
                <a target="_blank"
                    href="/program-<?php echo $image->afterschool_id; ?>-<?php echo $image->afterschool_filename; ?>.html"><?php echo $image->imagename; ?></a><br />
                <?php endif; ?>
                <?php echo $image->altname; ?><br />
            </td>
            <td>
                <?php if ($image->imageable_type == 'activity'): ?>
                <?php if (file_exists(public_path() . '/images/activity/' . $image->activity_id . "/" . $image->imagename)): ?>
                <img src="<?php echo asset('images/activity/' . $image->activity_id . '/' . $image->imagename); ?>" border="0" width="200" height="150" alt="<?php echo $image->altname; ?>"
                    onClick="window.open('<?php echo asset('images/activity/' . $image->activity_id . '/' . $image->imagename); ?>','mywindow','width=640,height=480,scrollbars=no,location=no')"
                    style="cursor:pointer;" />
                <?php else: ?>
                <p>File does not exist</p>
                <?php endif; ?>
                <?php else: ?>
                <?php if (file_exists(public_path() . '/images/afterschool/' . $image->afterschool_id . "/" . $image->imagename)): ?>
                <img src="<?php echo asset('images/afterschool/' . $image->afterschool_id . '/' . $image->imagename); ?>" border="0" width="200" height="150" alt="<?php echo $image->altname; ?>"
                    onClick="window.open('<?php echo asset('images/afterschool/' . $image->afterschool_id . '/' . $image->imagename); ?>','mywindow','width=640,height=480,scrollbars=no,location=no')"
                    style="cursor:pointer;" />
                <?php else: ?>
                <p>File does not exist</p>
                <?php endif; ?>
                <?php endif; ?>
            </td>
            <td>
                <form method="post" action="/admin/image/approve" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $image->id; ?>" />
                    <input class="btn btn-success" type="submit" value="Approve" />
                </form>
            </td>
            <td>
                <form method="post" action="/admin/image/disapprove" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $image->id; ?>" />
                    <input class="btn btn-warning" type="submit" value="Not Approve" />
                </form>
            </td>
            <td>
                <form method="post" action="/admin/image/delete" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $image->id; ?>" />
                    <input class="btn btn-danger" type="submit"value="Delete" />
                </form>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
@endsection
