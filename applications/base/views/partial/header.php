<!doctype html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title><?php echo prep_str($title);?></title>
        <link href="//fonts.googleapis.com/css?family=Lato:100,400" rel="stylesheet" type="text/css">
        <link href="//yui.yahooapis.com/pure/0.5.0/pure-min.css" rel="stylesheet" type="text/css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_link("css/index.css");?>" rel="stylesheet" type="text/css">
    </head>
    <body>
        <header class="lap-header">
        <h1><a href="<?php echo page_link();?>">Like A Pinboard</a></h1>
            <ul class="lap-menu">
                <?php if ( isset($user) ):?>
                <li>
                    <a href="<?php echo page_link("recent/pins");?>" class="lap-link">Recent pins</a>
                </li>
                <li class="right-side">
                    <a href="<?php echo page_link("signout");?>" class="lap-link">
                        <i class="fa fa-sign-out"></i>
                        Sign out
                    </a>
                </li>
                <li class="right-side lap-config">
                    <a href="<?php echo page_link("/");?>" class="lap-link">
                        <i class="fa fa-gear"></i>
                        <?php echo prep_str($user->name);?>
                    </a>
 <!-- Sorry, not implemented X(
                    <ul class="lap-submenu">
                        <li>
                            <a href="<?php echo page_link("my/tools");?>" class="lap-link">
                                <i class="fa fa-chain"></i>
                                Tools
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo page_link("my/account");?>" class="lap-link">
                                <i class="fa fa-user"></i>
                                Account
                            </a>
                        </li>
                    </ul>
-->
                </li>
                <?php endif;?>
            </ul>
        </header>
