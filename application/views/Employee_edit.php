<!doctype html>
<html lang="en">

<head>
<title>Employee edit</title>
    <?php
    $this->load->view('nav.php');
    $this->load->view('header.php');
    ?>
</head>
<div class="container">
    <form action="<?php echo base_url() . 'employee/update/' . $user['id'] ?>" method="post">
        <div class="form-group">
            <label for="username">Employee Name</label>
            <input type="text" class="form-control" id="username" name="name" value="<?php echo ucfirst(set_value('name', $user['name'])); ?>" placeholder="Enter Employee" autocomplete="off" required />
        </div>

        <div class="form-group">
            <label for="emailid">Email ID</label>
            <input type="email" class="form-control" id="emailid" name="email" value="<?php echo set_value('email', $user['email']); ?>" placeholder="Enter email" autocomplete="off" required />
        </div>
        <div class="dropdown">
            <label for="company">Select Company</label>
            <select name="company" id="company" class="form-control">
                <option value="<?php echo $user['company']; ?>" selected hidden><?php echo $user['company']; ?></option>
                <?php foreach ($company as $com) { ?>
                    <option value="<?php echo ucfirst($com['company']); ?>"><?php echo ucfirst($com['company']); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="dropdown">
            <label style="margin-top:12px;" for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control">
                <option value="<?php echo $user['gender']; ?>" selected hidden><?php echo $user['gender']; ?></option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <button type="submit" style="margin-top:12px;" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
<?php
$this->load->view('footer.php');
?>

</html>