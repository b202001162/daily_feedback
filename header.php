<?php
require_once 'functions.php';
require_once 'config.php';

if (!empty(SITE_ROOT)) {
    $url_path = "/" . SITE_ROOT . "/JustWriteIt/";
} else {
    $url_path = "/JustWriteIt/";
}

?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" ,initial-scale="1">
    <title>JustWriteIt</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kalam&display=swap');
    </style>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.19.1/ui/trumbowyg.min.css">
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
    <!-- favicon -->
    <link rel="shortcut icon" href="./favicon/favicon.ico" type="image/x-icon">
    <script>
        $(document).ready(function () {
            $(".icon-input-btn").each(function () {
                var btnFont = $(this).find(".btn").css("font-size");
                var btnColor = $(this).find(".btn").css("color");
                $(this).find(".fa").css({ 'font-size': btnFont, 'color': btnColor });
            });
        });
    </script>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand"><b>JustWriteIt</b></a>
            <form action="<?= $url_path ?>search.php" method="GET" class="d-flex input-group w-auto">
                <input type="text" name="q" class="form-control rounded" placeholder="Search" aria-label="Search"
                    aria-describedby="search-addon" id="navbar_search" />
                <span class="icon-input-btn" style="margin-left: 5px;">
                    <i class="fa fa-search"></i>
                    <input type="submit" class="btn btn-primary btn-lg" value=""
                        style="background-color: transparent; width: 100%; border: 0px; box-shadow: none;">
                </span>
            </form>
        </div>
    </nav>

    <!-- <a href="./add_new_post.php" style="cursor: pointer; position: fixed; bottom: 50px; right: 50px;"> -->
    <!-- </a> -->

    <div class="container">