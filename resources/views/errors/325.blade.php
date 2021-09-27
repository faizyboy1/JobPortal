<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>404 - Page Not Found</title>

    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<section id="wrapper" >
    <div class="row">
        <div class="col-md-12">
            <div class="error-body text-center">
                <h1 class="mt-5 text-primary">UH OH!</h1>
                <p class="lead">Company does not exists for that url</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-rounded"><i class="fa fa-lock"></i> Sign Up</a>
                <a href="{{ route('front.forgot-company') }}" class="btn btn-danger btn-rounded"><i class="fa fa-external-link"></i> Find Your Login Url</a>
            </div>
        </div>
    </div>

</section>


</body>
</html>

