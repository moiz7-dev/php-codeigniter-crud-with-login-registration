<!doctype html>
<html lang="en">

<head>
    <title>Company</title>
    <?php
    $this->load->view('nav.php');
    $this->load->view('header.php');
    ?>
</head>

<body>
    <div class="container mt-5">
        <h1 class="heading">Company CRUD</h1>
        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success" role="alert">' . $this->session->flashdata('success') . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['delete'])) {
            echo '<div class="alert alert-danger" role="alert">' . $this->session->flashdata('delete') . '</div>';
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
            unset($_SESSION['error']);
        }
        ?>
        <div class="row">
            <form class="col-sm-5" id="myForm" action="<?php echo base_url() . 'company/insert' ?>" method="post">
                <div class="container d-flex align-items-start flex-column p-2 mx-1 font-weight-bold col-md-4">
                    <div class="form-group">
                        <label for="company">Company Name</label>
                        <input type="text" class="form-control" id="company" name="company" placeholder="Enter Company" autocomplete="off" required />
                    </div>

                    <div class="form-group">
                        <label for="email">Email ID</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" autocomplete="off" required />
                    </div>

                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </form>
            <div class="col-sm-7 text-center tab">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Email ID</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $id = 0;
                        foreach ($users as $user) { ?>
                            <tr>
                                <td><?php echo $id += 1; ?></td>
                                <td><?php echo ucfirst($user['company']); ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td>
                                    <a href="<?php echo base_url() . 'company/edit/' . $user['id'] ?>"><button type='submit' class='btn btn-primary btn-sm' style='padding:1px 5px;'>Edit</button></a>
                                    <?= anchor(base_url() . 'company/delete/' . $user['id'], "<button type='submit' class='btn btn-danger btn-sm' style='padding:1px 5px;'>Delete</button>", array('onclick' => "return confirm('Do you want delete this record')")) ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<?php
$this->load->view('footer.php');
?>

</html>