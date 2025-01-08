@push('meta')
    <meta name="robots" content="noindex,follow">
@endpush

@push('title')
    <title>Upload Images - {{ $afterschool->name }}</title>
@endpush

@extends('layouts.app')

@section('content')
    <div id="left-col">
        <a href="/">Home</a> &gt;&gt;
        <a href="/program-<?php echo $afterschool->id; ?>-<?php echo $afterschool->filename; ?>.html"><?php echo $afterschool->name; ?></a> &gt;&gt;
        Upload Afterschool Photos

        <h2>Please use the tool below to upload pictures.</h2><br />
        <strong>Name:</strong> <?php echo $afterschool->name; ?> <br />
        <strong>Address:</strong> <?php echo $afterschool->address . ', ' . $afterschool->city . ' ' . $afterschool->state; ?>

        <?php if (isset($message)) :?>
        <p><?php echo $message; ?></p>
        <?php endif;?>

        @if ($imageCount < 8 && !isset($new_image->id))
            <form method="POST" enctype="multipart/form-data" class="clearfix">
                @csrf
                <table width="100%">
                    <tbody>
                        <tr>
                            <td><label for="image1">Upload Image #1:</label></td>
                            <td>
                                <input type="file" id="image1" name="image1">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="image1Alt">Image #1 Alternate Name:</label></td>
                            <td>
                                <input class="form-textbox" id="image1Alt" name="image1Alt" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="image2">Upload Image #2:</label></td>
                            <td>
                                <input type="file" id="image2" name="image2">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="image2Alt">Image #2 Alternate Name:</label></td>
                            <td>
                                <input class="form-textbox" id="image2Alt" name="image2Alt" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="submit" class="btn" value="Upload Images">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        @endif
        <br />
        <br />
        <?php if (count($images)) : ?>
        <h2>Below are the images you have uploaded:</h2>
        <?php
        /** @var \Application\Domain\Entity\Image $image */
        foreach ($images as $image): ?>
        <img src="<?php echo asset('images/afterschool/' . $afterschool->id . '/' . $image->imagename); ?>" border="0" width="200" height="150" alt="<?php echo $image->altname; ?>"
            onClick="window.open('<?php echo asset('images/afterschool/' . $afterschool->id . '/' . $image->imagename); ?>','mywindow','width=640,height=480,scrollbars=no,location=no')"
            style="cursor:pointer;" />
        <a href="/program/imagedelete?id=<?php echo $image->id; ?>">Remove this Image</a><br />
        <?php endforeach; ?>
        <?php endif;?>
    </div>    
@endsection
