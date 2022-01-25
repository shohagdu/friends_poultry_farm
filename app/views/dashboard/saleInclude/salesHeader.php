<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EASY SALES</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/hover.css">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/image/favicon.ico">
    <script>
        var base_url='<?php echo base_url() ?>';
    </script>
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">-->
    <!--        <link rel="stylesheet" href="-->
    <!--    --><?php //echo base_url(); ?><!--assets/bootstrap/fonts/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/fonts/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/fonts/css/jquery-ui.css">


    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">

    <style type="text/css">
        .myStyleCss {
            background: white
            height: 200px;
        }

        .inputStyle {
            height: 30px !important;
            text-align: center;

        }

        .thStyleNew {
            width: 30%;
            text-align: left;
            padding-bottom: 5px !important;
            padding-top: 5px !important;
            padding-left: 10px;

        }

        .tdStyleNew {
            width: 70%;
            text-align: center;
            padding-bottom: 5px !important;
            padding-top: 5px !important;
        }

        .appenTd {
            border-right: 2px solid #fff;
            border-bottom: 2px solid #fff;
        }

        td, th, div {
            text-transform: uppercase;
        }

        .search input {
            text-indent: 32px;
        }

        .search .glyphicon-search {
            position: absolute;
            top: 10px;
            left: 30px;
        }

        .search1 input {
            text-indent: 32px;
        }

        .search1 .glyphicon-search {
            position: absolute;
            top: 10px;
            left: 30px;
        }

        .btn-primary {
            font-family: TimeBurner;
            font-size: 15px;
            background-color: #232323;
            border-color: #222222;
        }

        .btn-success:hover {
            background-color: #111111;
            border-color: #000000;
        }

        .btn-success:focus,
        .btn-success:active,
        .btn-success.active {
            background-color: #111111;
            border-color: #000000;
        }

        /*//for scroll bar style*/

        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #e4b9c0;
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #b30000;
        }
        .paymentBy{
            font-weight: bold;
            vertical-align: middle !important;
        }


    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body class="hold-transition skin-black-light layout-top-nav">
<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header pull-left">
                    <a href="<?php echo base_url('welcome'); ?>" class="navbar-brand"><b>RED GREEN</b></a>
                </div>
                <div class="navbar-custom-menu pull-right">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="<?php echo base_url(); ?>"><i class="glyphicon glyphicon-dashboard"></i> Dashboard</a>
                        </li>
                        <li class="dropdown user user-menu">
                            <?php
                            $user = $this->session->userdata('user');
                            $admin_data = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_users', 'userID', $user);
                            ?>

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class=""><?php echo $admin_data['username'] ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo base_url('settings/profile') ?>"
                                           class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('login/logOut'); ?>"
                                           class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>