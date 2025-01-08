<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US" xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>

    <style>
        .wrapper {
            min-height: 100%;
            height: auto;
            margin: 0 auto -60px;
            padding: 80px 0 60px;
        }
        input.form-textbox, textarea.form-textbox {
            background: #FBFBFB;
            border: 1px solid #E5E5E5;
            box-shadow: 1px 1px 2px rgba(200, 200, 200, .2) inset;
            color: #555;
            font-size: 14px;
            font-weight: 200;
            line-height: 1;
            margin-bottom: 5px;
            margin-right: 6px;
            margin-top: 2px;
            outline: 0;
            padding: 7px;
            width: 90%;
        }
        .form-selectbox, .form-textarea-large {
            background-color: #FFF;
            border: 1px solid #CCC;
            width: 220px;
            border-radius: 4px;
            color: #555;
            font-size: 14px;
            margin-bottom: 10px;
            padding: 4px 6px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="/">AfterSchoolPrograms.us</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/afterschool/search">Find Afterschools</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/activity/search">Find Activities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/review">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/question">Q/A</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/visitor_counts">Visitor Counts</a>
                    </li>
                </ul>    
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $user->first_name . " " . $user->last_name; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="/user/logout">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</body>
</html>
