@extends('layouts.app_admin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Search Form</li>
        </ol>
    </nav>

    <h2>Search for Afterschools</h2>

    <?php if (isset($message)): ?>
    <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">
        @csrf
        <dl class="zend_form" style="width:50%">
            <dt id="name-label"><label for="name">Name:</label></dt>
            <dd id="name-element">
                @if (isset($request->name))
                    <input class="form-textbox" id="name" name="name" type="text" value="{{ $request->name }}">
                @else
                    <input class="form-textbox" id="name" name="name" type="text" value="">
                @endif
            </dd>
            <dt id="phone-label"><label for="phone">Phone:</label></dt>
            <dd id="phone-element">
                @if (isset($request->phone))
                    <input class="form-textbox" id="phone" name="phone" type="text" value="{{ $request->phone }}">
                @else
                    <input class="form-textbox" id="phone" name="phone" type="text" value="">
                @endif
            </dd>
            <dt id="address-label"><label for="address">Address:</label></dt>
            <dd id="address-element">
                @if (isset($request->address))
                    <input class="form-textbox" id="address" name="address" type="text" value="{{ $request->address }}">
                @else
                    <input class="form-textbox" id="address" name="address" type="text" value="">
                @endif
            </dd>
            <dt id="zip-label"><label for="zip">In ZIP Code (i.e. 33781):</label></dt>
            <dd id="zip-element">
                @if (isset($request->zip))
                    <input class="form-textbox" id="zip" name="zip" type="text" value="{{ $request->zip }}">
                @else
                    <input class="form-textbox" id="zip" name="zip" type="text" value="">
                @endif
            </dd>
            <dt id="city-label"><label for="city">City (i.e Orlando):</label></dt>
            <dd id="city-element">
                @if (isset($request->city))
                    <input class="form-textbox" id="city" name="city" type="text" value="{{ $request->city }}">
                @else
                    <input class="form-textbox" id="city" name="city" type="text" value="">
                @endif
            </dd>
            <dt id="state-label"><label for="state">State:</label></dt>
            <dd id="state-element">
                <select class="form-selectbox" id="state" name="state">
                    <option value="">-Select-</option>
                    @foreach ($states as $state)
                        @if (isset($request->state))
                            @if ($state->state_code == $request->state)
                                <option value='{{ $state->state_code }}' selected>
                                    {{ $state->state_name }}
                                </option>
                            @else
                                <option value='{{ $state->state_code }}'>{{ $state->state_name }}</option>
                            @endif
                        @else
                            <option value='{{ $state->state_code }}'>{{ $state->state_name }}</option>
                        @endif
                    @endforeach
                </select>
            </dd>
            <dt id="email-label"><label for="email">Email address:</label></dt>
            <dd id="email-element">
                @if (isset($request->email))
                    <input class="form-textbox" id="email" name="email" type="email" value="{{ $request->email }}">
                @else
                    <input class="form-textbox" id="email" name="email" type="email" value="">
                @endif
            </dd>
            <dt id="id-label"><label for="id">ID:</label></dt>
            <dd id="id-element">
                @if (isset($request->id))
                    <input class="form-textbox" id="id" name="id" type="text" value="{{ $request->id }}">
                @else
                    <input class="form-textbox" id="id" name="id" type="text" value="">
                @endif
            </dd>
            <dt id="search-label">&nbsp;</dt>
            <dd id="search-element">
                <input type="submit" name="search" id="search" value="Search">
            </dd>
        </dl>
    </form>

    <?php if (isset($afterschools)):?>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th colspan="2">Action</th>
        </tr>
        <?php $i = 0; 
        /** @var \Application\Domain\Entity\Facility $afterschool */
        foreach ($afterschools as $afterschool): ?>
        <tr class="d<?php echo $i % 2;
        $i++; ?>">
            <td width="40%">
                <a target="_blank" href="/program-<?php echo $afterschool->id; ?>-<?php echo $afterschool->filename; ?>.html"><?php echo $afterschool->name; ?></a><br />
                <?php echo $afterschool->phone; ?>
            </td>
            <td width="30%">
                <?php echo $afterschool->address; ?> <br />
                <?php echo $afterschool->city . ', ' . $afterschool->state . ' ' . $afterschool->zip; ?>
            </td>
            <td>
                <form method="get" action="/admin/afterschool/edit">
                    <input type="hidden" name="id" value="<?php echo $afterschool->id; ?>" />
                    <input type="submit" value=" Update " />
                </form>
            </td>
            <td>
                <?php if ($afterschool->approved >= 0) : ?>
                <form method="post" action="/admin/afterschool/delete">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $afterschool->id; ?>" />
                    <input type="submit" name="delete" value="Delete " />
                </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach;?>
    </table><br />
    <?php endif; ?>
@endsection
