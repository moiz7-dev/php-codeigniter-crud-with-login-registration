    <!doctype html>
    <html lang="en">

    <head>
        <title>Edit profile</title>
        <?php
        $this->load->view('header.php');
        $this->load->view('nav.php');
        ?>
        <link rel="stylesheet" href="<?php echo base_url('css\profile_edit.css') ?>">
    </head>

    <body>
        <div class="container mt-2">
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-success" role="alert">' . $this->session->flashdata('error') . '</div>';
                unset($_SESSION['error']);
            }

            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success" role="alert">' . $this->session->flashdata('success') . '</div>';
                unset($_SESSION['success']);
            }
            ?>
        </div>
        <div class="container rounded bg-white mt-5">
            <form action="<?php echo base_url() . 'user/profile' ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <img class="rounded-circle mt-5" src="<?php echo (base_url() . $user['profile_img']); ?>" width="90">
                            <span class="font-weight-bold"><?php echo (ucfirst($user['user'])); ?></span><span class="text-black-50"><?php echo ($user['email']); ?></span>
                            <input id="profile_img" name="profile_img" type="file" />
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-row align-items-center back"><i class="fa fa-long-arrow-left mr-1 mb-1"></i>
                                    <a href="<?php echo base_url('dashboard') ?>">
                                        <h6>Back to home</h6>
                                    </a>
                                </div>
                                <h6 class="text-right">Edit Profile</h6>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6"><input type="text" class="form-control" name="fname" placeholder="first name" value="<?php echo ($user['fname']); ?>"></div>
                                <div class="col-md-6"><input type="text" class="form-control" name="lname" placeholder="last name" value="<?php echo ($user['lname']); ?>"></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6"><input type="text" class="form-control" name="uname" placeholder="Username" value="<?php echo ($user['user']); ?>"></div>
                                <div class="col-md-6"><input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo ($user['email']); ?>"></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <a href="<?php echo base_url('user/change_password') ?>" class="sub_btn">Change Password</a>
                                </div>
                            </div>
                            <div class="mt-5 text-right"><button class="btn btn-primary profile-button" type="submit" name="submit">Save Profile</button></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </body>

    <?php
    $this->load->view('footer.php');
    ?>

    </html>