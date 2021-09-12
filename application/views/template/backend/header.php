<div class="header">
    <div class="header-left">
        <a href="index.html" class="logo">
            <img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo">
        </a>
        <a href="index.html" class="logo logo-small">
            <img src="<?php echo base_url('assets/img/logo-small.png'); ?>" alt="Logo" width="30" height="30">
        </a>
    </div>

    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fas fa-bars"></i>
    </a>
    <div class="top-nav-search">
        <form>
            <input type="text" class="form-control" placeholder="Search here">
            <button class="btn" type="submit"><i class="fa fa-search"></i>
            </button>
        </form>
    </div>
    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>
    <ul class="nav user-menu">

        <li class="nav-item dropdown">
            <a href="#" class="nav-link notifications-item">
                <i class="feather-bell"></i> <span class="badge badge-pill">3</span>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a href="chat.html" class="dropdown-toggle nav-link chat-header">
                <i class="feather-message-square"></i> <span class="badge badge-pill header-chat">6</span>
            </a>
        </li>

        <li class="nav-item dropdown has-arrow main-drop ml-md-3">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img"><img src="<?php echo base_url('assets/img/avatar.jpg'); ?>" alt="">
                    <span class="status online"></span></span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#"><i class="feather-user"></i> My Profile</a>
                <a href="javascript:void(0)" class="dropdown-item auth-logout"><i class="feather-power"></i> Logout</a>
            </div>
        </li>
    </ul>
</div>