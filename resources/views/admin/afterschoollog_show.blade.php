@extends('layouts.app_admin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Afterschool Update Compare</li>
        </ol>
    </nav>
    <a target="_blank" href="/program-<?php echo $afterschool->id?>-<?php echo $afterschool->filename ?>.html"><?php echo $afterschool->name ?></a>
    <table class="table">
        <tr>
            <th>Field Name</th>
            <th>Old</th>
            <th>New</th>
        </tr>
        @if ( $afterschool->name != $afterschoolLog->name )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Afterschool Name</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->program_name; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->program_name; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->location != $afterschoolLog->location )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Location</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->location; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->location; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->address != $afterschoolLog->address )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Address</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->address; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->address; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->address2 != $afterschoolLog->address2 )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Address2</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->address2; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->address2; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->city != $afterschoolLog->city )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">City</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->city; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->city; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->state != $afterschoolLog->state )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">State</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->state; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->state; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->zip != $afterschoolLog->zip )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Zip</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->zip; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->zip; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->phone != $afterschoolLog->phone )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Phone</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->phone; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->phone; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->phone_ext != $afterschoolLog->phone_ext )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Phone Ext</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->phone_ext; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->phone_ext; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->county != $afterschoolLog->county )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">County</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->county; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->county; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->email != $afterschoolLog->email )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Email</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->email; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->email; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->capacity != $afterschoolLog->capacity )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Capacity</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->capacity; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->capacity; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->status != $afterschoolLog->status )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Status</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->status; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->status; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->type != $afterschoolLog->type )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Type</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->type; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->type; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->contact_firstname != $afterschoolLog->contact_firstname )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Contact Firstname</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->contact_firstname; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->contact_firstname; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->contact_lastname != $afterschoolLog->contact_lastname )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Contact Lastname</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->contact_lastname; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->contact_lastname; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->age_range != $afterschoolLog->age_range )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Age Range</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->age_range; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->age_range; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->transportation != $afterschoolLog->transportation )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Transportation</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->transportation; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->transportation; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->state_rating != $afterschoolLog->state_rating )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">State Rating</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->state_rating; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->state_rating; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->website != $afterschoolLog->website )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Website</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->website; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->website; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->subsidized != $afterschoolLog->subsidized )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Subsidized</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->subsidized; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->subsidized; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->accreditation != $afterschoolLog->accreditation )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Accreditation</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->accreditation; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->accreditation; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->daysopen != $afterschoolLog->daysopen )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Days Open</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->daysopen; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->daysopen; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->hoursopen != $afterschoolLog->hoursopen )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Hours Open</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->hoursopen; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->hoursopen; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->typeofcare != $afterschoolLog->typeofcare )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Type Of Care</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->typeofcare; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->typeofcare; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->language != $afterschoolLog->language )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Language</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->language; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->language; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->introduction != $afterschoolLog->introduction )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Introduction</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->introduction; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->introduction; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->additionalInfo != $afterschoolLog->additionalInfo )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Additional Info</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->additionalInfo; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->additionalInfo; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->pricing != $afterschoolLog->pricing )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Pricing</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->pricing; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->pricing; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->schools_served != $afterschoolLog->schools_served )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Schools Served</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->schools_served; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->schools_served; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->category != $afterschoolLog->category )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Category</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->category; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->category; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->provider_status != $afterschoolLog->provider_status )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Provider Status</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->provider_status; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->provider_status; ?>
                </td>
            </tr>
        @endif
        @if ( $afterschool->claim != $afterschoolLog->claim )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Claim</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschool->claim; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $afterschoolLog->claim; ?>
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="3" style="text-align: left">
                <form method="post" action="/admin/afterschool-log/approve" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $afterschoolLog->id; ?> " />
                    <input type="submit" class="btn btn-success" value="Approve" />
                </form>
                <form method="post" action="/admin/afterschool-log/disapprove" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $afterschoolLog->id; ?> " />
                    <input type="submit" class="btn btn-warning" value="Not Approve" />
                </form>
                <form method="post" action="/admin/afterschool-log/delete" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $afterschoolLog->id; ?> " />
                    <input type="submit" class="btn btn-danger" value="Delete" />
                </form>
            </td>
        </tr>
    </table>
@endsection
