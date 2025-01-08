@extends('layouts.app_admin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">New Reviews</li>
        </ol>
    </nav>

    <h3 class="page-header">New Reviews</h3>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>By</th>
            <th>Comments</th>
            <th colspan="3">Action</th>
        </tr>
        <?php
    /** @var \Application\Domain\Entity\Review $review */
    foreach ($reviews as $review): ?>
        <?php if ($review->commentable_type == 'activity'):
            /** @var \Application\Domain\Entity\Activity $activity */
            // $activity = $this->activityRepository->getById($review->getCommentableId());

            // if (!$activity) continue;
            ?>
        <?php else:
            /** @var \Application\Domain\Entity\Afterschool $afterschool */
            // $afterschool = $this->afterschoolRepository->getById($review->getCommentableId());

            // if (!$afterschool) continue;
            ?>
        <?php endif; ?>
        <tr>
            <td>
                <?php if ($review->commentable_type == 'activity'):?>
                <a target="_blank"
                    href="/<?php echo $review->category == 'MARTIAL-ARTS' ? 'activity' : 'sportclub'; ?>-<?php echo $review->activity_id; ?>-<?php echo $review->filename; ?>.html"><?php echo $review->review_by; ?></a><br />
                <?php else: ?>
                <a target="_blank"
                    href="/program-<?php echo $review->afterschool_id; ?>-<?php echo $review->filename; ?>.html"><?php echo $review->review_by; ?></a><br />
                <?php endif; ?>
                <?php echo $review->email; ?> <br />
                <?php echo $review->review_date; ?><br />
                <?php echo $review->ip_address; ?>
            </td>
            <td>
                <?php echo isset($review->user_name) ? $review->user_name : $review->review_by; ?>
            </td>
            <td width="500">
                <?php echo $review->comments; ?>
            </td>
            <td>
                <form method="post" action="/admin/review/approve">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $review->id; ?>" />
                    <input type="submit" class="btn btn-success" value="Approve" />
                </form>
            </td>
            <td>
                <form method="post" action="/admin/review/disapprove">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $review->id; ?>" />
                    <input type="submit" class="btn btn-warning" value="Not Approve" />
                </form>
            </td>
            <td>
                <form method="post" action="/admin/review/delete">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $review->id; ?>" />
                    <input type="submit" class="btn btn-danger" value="Delete" />
                </form>
            </td>

        </tr>
        <?php endforeach;?>
    </table>
@endsection
