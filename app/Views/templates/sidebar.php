<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/" target="_blank">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-hospital"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RSUI YAKSSI</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class=" nav-link" href="<?= base_url(); ?>user">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- User Management -->
    <?php if (in_groups('admin')) : ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            User Management
        </div>

        <!-- Nav Item - User List -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>admin">
                <i class="fas fa-users"></i>
                <span>User List</span></a>
        </li>
    <?php endif; ?>

    <!-- Nav Item - My Profile -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>user/profile">
            <i class="fas fa-user"></i>
            <span>My Profile</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Page Management
    </div>

    <!-- Nav Item - Beranda -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>control/beranda">
            <i class="fas fa-home"></i>
            <span>Beranda</span></a>
    </li>

    <!-- Nav Item - Widget -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>control/widget" ; ?>
            <i class="fas fa-images"></i>
            <span>Widget</span></a>
    </li>

    <!-- Nav Item - Pages -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>control/pages" ; ?>
            <i class="fas fa-file"></i>
            <span>Halaman</span></a>
    </li>

    <!-- Nav Item - Posts -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>control/posts" ; ?>
            <i class="fas fa-book"></i>
            <span>Post</span></a>
    </li>

    <!-- Nav Item - Category -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>control/category" ; ?>
            <i class="fas fa-tasks"></i>
            <span>Kategori</span></a>
    </li>

    <!-- Nav Item - Pesan -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>user/pesan" ; ?>
            <i class="fas fa-comment"></i>
            <span>Pesan</span></a>
    </li>

    <!-- Nav Item - Settings -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>control/settings" ; ?>
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span></a>
    </li>

    <!-- Nav Item - Menu Manager -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>control/menu" ; ?>
            <i class="fas fa-sitemap"></i>
            <span>Menu Manager</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>