<style>
    .dropdown-menu>li>a {
        cursor: pointer;
    }

    .navbar-brand img {
        width: 50px;
        margin: -16px 7px;
        position: absolute;
    }

    .navbar-brand span {
        margin: 0 55px;
    }
</style>

<div class="container-header">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url('page/home'); ?>">
            <img src="<?php echo base_url('assets/img/logo.png') ?>" alt="">
            <span>
                AHASS JATENG
            </span>
        </a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li <?php echo !empty($menu) ? (!empty($link) && $menu == 'dashboard' ?  "class='$link'" : '') : '' ?>><a href="<?php echo base_url('page/dashboard'); ?>">
                    <em class="glyphicon glyphicon-signal"></em> Dashboard</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $this->session->userdata('nama') ?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modalProfile"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah Password</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="javascript:void(0)" class="auth-logout"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>