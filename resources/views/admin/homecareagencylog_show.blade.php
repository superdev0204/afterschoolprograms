@extends('layouts.app_admin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Health Home Care Update Compare</li>
        </ol>
    </nav>
    <a target="_blank" href="/sc/<?php echo $agency->FileName; ?>"><?php echo $agency->Provider_Name; ?></a>
    <table class="table">
        <tr>
            <th>Field Name</th>
            <th>Old</th>
            <th>New</th>
        </tr>
        @if ( $agency->Provider_Name != $agencyLog->provider_name )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Provider Name</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agency->Provider_Name; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agencyLog->provider_name; ?>
                </td>
            </tr>
        @endif
        @if ( $agency->Address != $agencyLog->address )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Address</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agency->Address; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agencyLog->address; ?>
                </td>
            </tr>
        @endif
        @if ( $agency->City != $agencyLog->city )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">City</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agency->City; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agencyLog->city; ?>
                </td>
            </tr>
        @endif
        @if ( $agency->STATE_CODE != $agencyLog->state )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">State</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agency->STATE_CODE; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agencyLog->state; ?>
                </td>
            </tr>
        @endif
        @if ( $agency->Zip != $agencyLog->zip )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Zip</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agency->Zip; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agencyLog->zip; ?>
                </td>
            </tr>
        @endif
        @if ( $agency->Phone != $agencyLog->phone )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Phone</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agency->Phone; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agencyLog->phone; ?>
                </td>
            </tr>
        @endif
        @if ( $agency->website != $agencyLog->website )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Website</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agency->website; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agencyLog->website; ?>
                </td>
            </tr>
        @endif
        @if ( $agency->description != $agencyLog->description )
            <tr class="d0">
                <td style="word-break: break-all; width: 20%">Description</td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agency->description; ?>
                </td>
                <td style="word-break: break-all; width: 40%">
                    <?php echo $agencyLog->description; ?>
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="3" style="text-align: left">
                <form method="post" action="/admin/homecare-agency-log/approve" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $agencyLog->id; ?> " />
                    <input type="submit" class="btn btn-success" value="Approve" />
                </form>
                <form method="post" action="/admin/homecare-agency-log/disapprove" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $agencyLog->id; ?> " />
                    <input type="submit" class="btn btn-warning" value="Not Approve" />
                </form>
                <form method="post" action="/admin/homecare-agency-log/delete" style="display: inline-block">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $agencyLog->id; ?> " />
                    <input type="submit" class="btn btn-danger" value="Delete" />
                </form>
            </td>
        </tr>
    </table>
@endsection
