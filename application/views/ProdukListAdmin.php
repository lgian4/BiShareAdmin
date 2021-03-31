<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produk List Admin (<?php echo ucfirst($produkstatus) ?>) </h1>

    </div>
    <div class="card shadow mb-4">
        <div class="card-header ">
            <div class="text-center text-danger">
                <?php echo $error ?>
            </div>
            <a href="<?php echo site_url('Produk/Produklist/pending') ?>" class="btn btn-warning  btn-icon-split">

                <span class="icon text-white-50">
                    <i class="fas fa-clock"></i>
                </span>
                <span class="text">Pending</span>
            </a>
            <a href="<?php echo site_url('Produk/Produklist/approve') ?>" class="btn btn-success  btn-icon-split">

                <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                </span>
                <span class="text">Approve</span>
            </a>
            <a href="<?php echo site_url('Produk/Produklist/reject') ?>" class="btn btn-danger  btn-icon-split">

                <span class="icon text-white-50">
                    <i class="fas fa-window-close"></i>
                </span>
                <span class="text">Reject</span>
            </a>
            <hr>
            <a href="<?php echo site_url("Produk/ProdukForm/null/$tokoid") ?>" class="btn btn-primary  btn-icon-split">

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
                            <th>Toko</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i= 1; ?>
                        <?php foreach($produk as $row): ?>

                        <tr>
                            <?php if($row['dlt']) continue; ?>
                            <td><?php echo $i++; ?></td>

                            <td><?php echo $row['produkcode']; ?></td>
                            <td><?php echo $row['produkname']; ?></td>
                            <td><?php echo $row['tokoname']; ?></td>
                            <td><?php echo $row['kategoriname']; ?></td>
                            <td><?php echo $row['status']; ?></td>

                            <td>
                                <a href="<?php echo site_url('Produk/ProdukForm/'.$row['produkid']) ?>"
                                    class="btn btn-primary btn-circle btn-sm">
                                    <i class="fa fa-link"></i>
                                </a>
                                <button
                                    onclick="DeleteData('<?php echo $row['produkcode'] ?>','<?php echo $row['produkid'] ?>')"
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
    swal.fire({
        title: "Apakah anda yakin untuk menghapus",
        icon: 'error',
        text: "Produk code : " + xusercode,
        showCancelButton: true,

        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        buttonsStyling: true
    }).then(function() {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Produk/Delete') ?>",
                data: {
                    'produkid': xuserid
                },
                cache: false,
                success: function(response) {
                    console.log(response);
                    if (response['success']) {
                        swal.fire(
                            "Success!",
                            "Data telah terhapus!",
                            "success"
                        );
                        location.reload();
                    } else {

                        swal.fire(
                            response['head'],
                            response['text'],
                            "error"
                        );
                    }

                },
                failure: function(response) {
                    swal.fire(
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