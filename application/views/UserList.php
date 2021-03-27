<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User List</h1>

    </div>
    <div class="card shadow mb-4">
        <div class="card-header ">
        <div class="text-center text-danger">
                                        <?php echo $error ?>
                                    </div>
            <a href="<?php echo site_url('User/UserForm') ?>" class="btn btn-primary  btn-icon-split">
           
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Start date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i= 1; ?>
                        <?php foreach($users as $row): ?>

                        <tr>
                            <?php if($row['dlt']) continue; ?>
                            <td><?php echo $i++; ?></td>

                            <td><?php echo $row['usercode']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['userdate']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td> 
                                <a href="<?php echo site_url('User/UserForm/'.$row['userid']) ?>" class="btn btn-primary btn-circle btn-sm">
                                        <i class="fa fa-link"></i>
                                    </a>
                                </td>
                        </tr>
                        <?php endforeach; ?>



                    </tbody>
                </table>
            </div>
        </div>
    </div>



</div>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
<!-- /.container-fluid -->