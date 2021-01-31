<!doctype html>
<html lang="en">

<head>
    <title>Change password</title>
    <?php
    $this->load->view('nav.php');
    $this->load->view('header.php');
    ?>
</head>

<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <span class="anchor" id="formChangePassword"></span>
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
                    unset($_SESSION['error']);
                }
                ?>
                <div class="card card-outline-secondary">
                    <div class="card-header">
                        <h3 class="mb-0">Change Password</h3>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" autocomplete="off" action="<?php echo base_url('user/change_password') ?>" method="POST">
                            <div class="form-group">
                                <label for="current_pass">Current Password</label>
                                <input type="password" class="form-control" name="oldpassword" id="oldpassword" required>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                            <div class="form-group">
                                <label for="cpassword">Confirm Password</label>
                                <input type="password" name="cpassword" class="form-control" id="cpassword" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-success btn-lg float-right">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
</body>

<?php
$this->load->view('footer.php');
?>

</html>