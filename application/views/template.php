<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{pagetitle}</title>
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="icon" href="/pix/icons/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="/assets/css/default.css"/>
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/sb-admin-2.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.min.css">
        <script type="text/javascript" src="/assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
    </head>

    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/home">Apple BotFactory</a>
                </div>
                <ul class="nav navbar-top-links">
                    {navbuttons}
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">User Role<b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <li><a href="/roles/actor/Guest">Guest</a></li>
                            <li><a href="/roles/actor/Worker">Worker</a></li>
                            <li><a href="/roles/actor/Supervisor">Supervisor</a></li>
                            <li><a href="/roles/actor/Boss">Boss</a></li>
                      </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="container">
            {content}
            <p class="footer"><strong>BotFactory brought to you by Team Apple.</strong></p>
        </div>

    </body>
</html>