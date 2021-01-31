    <!doctype html>
    <html lang="en">

    <head>
        <title>Dashboard</title>
        <?php
        $this->load->view('nav.php');
        $this->load->view('header.php');
        ?>
        <style>
            .color {
                background-color: #f2eedf;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <?php if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success mt-2" role="alert">' . $this->session->flashdata('success') . '</div>';
                unset($_SESSION['success']);
            }
            ?>
        </div>
        <div class="col-sm-12 col-md-12 well color" id="content">
            <h1>You're Logged in</h1>
            <h2>Welcome <?php echo ucfirst($_SESSION['user_name']); ?>!</h2>

        </div>

    </body>

    <?php
    $this->load->view('footer.php');
    ?>

    </html>