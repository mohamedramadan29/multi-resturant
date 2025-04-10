<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="{{ $resturantsetting->setting }}" />

    <!-- Title -->
    <title> {{ $resturantsetting->name }} </title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ $resturantsetting->getLogo() }}" />
    <link rel="apple-touch-icon" href="{{ $resturantsetting->getLogo() }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ $resturantsetting->getLogo() }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ $resturantsetting->getLogo() }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ $resturantsetting->getLogo() }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zain:wght@200;300;400;700;800;900&display=swap"
        rel="stylesheet">


    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Zain", serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        .error-code {
            font-weight: bold;
            color: #ff6b6b;
        }

        .home-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #FBB03B;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .home-link:hover {
            background-color: #FBB03B;
        }

        .illustration {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }
    </style>
</head>



<body>
    <div class="container">
        <div class="error-code">
            <img style="max-width:50%" src="{{ $resturantsetting->getLogo() }}" alt="">
        </div>
        <section class="hero" id="start">
            <div class="container">
                <h1 class="display-4">نظام ذكي لإدارة مطعمك بكل سهولة</h1>
                <p class="lead">تجربة مجانية لمدة 15 يومًا !</p>
            </div>
        </section>
        <a href="{{ $resturantsetting->whatsapp }}" class="home-link"> تواصل معنا الان </a>
    </div>
</body>

</html>
