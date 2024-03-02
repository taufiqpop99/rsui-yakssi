<?= $this->extend('user/templates/index'); ?>
<?= $this->section('page-content'); ?>

<!-- User List -->
<div class="container-fluid">
    <div class="row">
        <div class="col-11">
            <h1 class="h3 mb-4 text-gray-800">User List</h1>

            <!-- Search Bar -->
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search" name="keyword" autofocus>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Messages -->
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>

            <!-- Table User List -->
            <div class="row card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col" class="cursor-active">No</th>
                                    <th scope="col" class="cursor-stop">Photo Profile</th>
                                    <th scope="col" class="cursor-active">Full Name</th>
                                    <th scope="col" class="cursor-active">Username</th>
                                    <th scope="col" class="cursor-stop">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1 + (5 * ($currentPage - 1)); ?>
                                <?php foreach ($users as $users) : ?>
                                    <tr>
                                        <th scope="row"><?= $i++; ?></th>
                                        <td>
                                            <img src="<?= base_url(); ?>img/user/<?= $users['user_image']; ?>" class="thumbnail">
                                        </td>
                                        <td><?= $users['fullname']; ?></td>
                                        <td><?= $users['username']; ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/detail/' . $users['id']); ?>" class="btn btn-info">Details</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- Pagers -->
                        <?= $pager->links('users', 'users_pagination'); ?>
                    </div>
                </div>
            </div>
            <!-- End User List -->
        </div>
    </div>
</div>

<?= $this->endSection(); ?>