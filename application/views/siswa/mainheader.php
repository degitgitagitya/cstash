<?php 
if (!$this->session->userdata('login')) {
    redirect(base_url());
}
if ($this->session->userdata('akses')!='siswa') {
    redirect(site_url('admin'));
 } 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo "$judul"; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Tables are the backbone of almost all web applications.">
    <meta name="msapplication-tap-highlight" content="no">
    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
<link href="<?php echo base_url();?>/assets/UI/main.css" rel="stylesheet">
<!-- bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- font awesome -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/faws/css/font-awesome.min.css">

</head>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="" > <a href="<?php echo base_url();?>"><img src="<?php echo base_url(),"assets/UI/assets/images/logo-inverse.png";?>"></a></div>
                <div class="header__pane ml-auto">
                </div>
            </div>
            <div class="app-header__menu">
            </div>    
            <div class="app-header__content">
                <div class="app-header-left">
                    <ul class="header-menu nav">
                        <li class="btn-group nav-item">
                            <a href="<?php echo base_url('Siswa/daftar_tugas'); ?>" class="nav-link">
                                <i class="nav-link-icon fa fa-edit"></i>
                                Daftar Tugas
                            </a>
                        </li>
                        <!-- <li class="dropdown nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-link-icon fa fa-cog"></i>
                                Settings
                            </a>
                        </li> -->
                    </ul>        </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        <?php echo $this->session->userdata('nama'); ?>
                                    </div>
                                    <div class="widget-subheading">
                                        <?php echo $this->session->userdata('nis'); ?>
                                    </div>
                                </div>
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                            <button type="button" tabindex="0" class="dropdown-item">Settings</button>
                                            <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                            <button type="button" tabindex="0" class="dropdown-item">Actions</button>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <a href="<?php echo site_url('Welcome/Logout');?>" class="dropdown-item" tabindex="0" class="dropdown-item">logout</a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>        </div>
            </div>
        </div>
        <div class="app-main">
                <div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading">Menu</li>
                                <li>
                                    <a href="<?php echo site_url('Admin') ?>" class="metismenu-icon" style="font-size:17px;">
                                        <i class="metismenu-icon fa fa-home"></i>
                                        <?php
                                        if ($judul == 'Dashboard') {
                                             echo "<strong>Dashboard</strong>";
                                         }else {
                                             echo "Dashboard";
                                         } ?>
                                    </a>
                                </li>
                                <li class="app-sidebar__heading metismenu-icon">Sesi</li>
                                <?php foreach ($sesi as $key) {
                                    ?>
                                    <li>
                                   <button style="font-size:17px;" class="btn fa <?php echo $key->id_icon ?>" data-toggle="collapse" data-target="#collapse<?php echo $key->id_sesi ?>" aria-expanded="true" aria-controls="collapse<?php echo $key->id_sesi ?>">
                                        <?php echo $key->nama_sesi; ?>
                                    </button>
                                   <ul style="text-align: left; margin-right: 0px;" id="collapse<?php echo $key->id_sesi ?>" class="collapse show" aria-labelledby="headingOne">
                                    <?php foreach ($topik as $value) {
                                        ?>
                                        
                                        <?php
                                        if ($value->id_sesi == $key->id_sesi) {
                                         ?>
                                       <li> <a class="metismenu-icon" href="<?php echo site_url("Siswa/sesi/$key->nama_sesi/$value->nama_topik")?>"><button style="font-size:15px; cursor: pointer; border: none; background: none;" class="fa"><?php echo $value->nama_topik ?></button></a></li>
                                        </li>
                                         <?php

                                        }
                                        ?>
                                        <?php
                                    } ?>

                                        </ul>
                                    </li>
                                    <?php
                                } 
                                 ?>
                                <li>
                                    <a href="#" class="metismenu-icon" style="font-size:17px;">
                                        <i class="font-weight-normal metismenu-icon fa fa-pencil-square-o"></i>
                                        <?php
                                        if ($judul == 'Postest') {
                                             echo "<strong>Postest</strong>";
                                         }else {
                                             echo "Postest";
                                         } ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>    
                    <div style="margin: 10px 30px 0 320px; width: 100%;">
                        