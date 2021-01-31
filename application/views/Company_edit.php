<!doctype html>
<html lang="en">

<head>
<title>Company Edit</title>
    <?php
    $this->load->view('nav.php');
    $this->load->view('header.php');
    ?>
</head>
<div class="container">
    <?php echo form_open('company/update/' . $user["id"]);?>
        <div class="form-group">
            <label for="username">Company Name</label>
            <input type="text" class="form-control" id="username" name="company" value="<?php echo ucfirst(set_value('company', $user['company'])); ?>" placeholder="Enter Employee" autocomplete="off" required />
        </div>

        <div class="form-group">
            <label for="emailid">Email ID</label>
            <input type="email" class="form-control" id="emailid" name="email" value="<?php echo set_value('email', $user['email']); ?>" placeholder="Enter email" autocomplete="off" required />
        </div>
        <button type="submit" class="btn btn-primary" value="update">Update</button>
    <?php form_close('</div>');?>
</body>
<?php
$this->load->view('footer.php');
?>

</html>