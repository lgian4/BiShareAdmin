<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Toko List (<?php echo ucfirst($tokostatus) ?>)</h1>

    </div>
    <div class="card shadow mb-4">
        <div class="card-header ">
            <div class="text-center text-danger">
                <?php echo $error ?>
            </div>
            <a href="<?php echo site_url('Toko/Index/pending') ?>" class="btn btn-warning  btn-icon-split">

                <span class="icon text-white-50">
                    <i class="fas fa-clock"></i>
                </span>
                <span class="text">Pending</span>
            </a>
            <a href="<?php echo site_url('Toko/Index/approve') ?>" class="btn btn-success  btn-icon-split">

                <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                </span>
                <span class="text">Approve</span>
            </a>
            <a href="<?php echo site_url('Toko/Index/reject') ?>" class="btn btn-danger  btn-icon-split">

                <span class="icon text-white-50">
                    <i class="fas fa-window-close"></i>
                </span>
                <span class="text">Reject</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Nama</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i= 1; ?>
                        <?php foreach($toko as $row): ?>

                        <tr>
                            <?php if($row['dlt']) continue; ?>
                            <td><?php echo $i++; ?></td>

                            <td><?php echo $row['tokocode']; ?></td>
                            <td><?php echo $row['tokoname']; ?></td>
                            <td><?php echo $row['tokodate']; ?></td>

                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href="<?php echo site_url('Toko/TokoForm/'.$row['userid'].'/'.$row['tokoid']) ?>"
                                    class="btn btn-primary btn-circle btn-sm">
                                    <i class="fa fa-link"></i>
                                </a>
                                <button
                                    onclick="DeleteData('<?php echo $row['tokoname'] ?>','<?php echo $row['tokoid'] ?>')"
                                    class="btn btn-danger btn-circle btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
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

function DeleteData(xusercode, xuserid) {
    swal({
        title: "Apakah anda yakin untuk menghapus",
        type:'error',text: "Toko Code : " + xusercode,
        showCancelButton: true,

        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        buttonsStyling: true
    },function() {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Toko/Delete') ?>",
                data: {
                    'tokoid': xuserid
                },
                cache: false,
                success: function(response) {
                    console.log(response);
                    if (response['success']) {
                        swal(
                            "Success!",
                            "Data telah terhapus!",
                            "success"
                        );
                        location.reload();
                    } else {

                        swal(
                            response['head'],
                            response['text'],
                            "error"
                        );
                    }

                },
                failure: function(response) {
                    swal(
                        "Internal Error",
                        "Oops, your note was not saved.", // had a missing comma
                        "error"
                    )
                }
            });
        },
        function(dismiss) {

        });
}
</script>
<!-- /.container-fluid -->