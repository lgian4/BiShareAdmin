<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Diskusi List</h1>

    </div>
    <div class="card shadow mb-4">
        <div class="card-header ">
            <div class="text-center text-danger">
                <?php echo $error ?>
            </div>
            <a href="<?php echo site_url('Diskusi/DiskusiForm') ?>" class="btn btn-primary  btn-icon-split">

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
                            
                            <th>Name</th>
                            <th>Deskripsi</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i= 1; ?>
                        <?php foreach($diskusi as $row): ?>

                        <tr>
                            <?php if($row['dlt']) continue; ?>
                            <td><?php echo $i++; ?></td>

                          
                            <td><?php echo $row['diskusiname']; ?></td>
                            <td><?php echo $row['diskusidesc']; ?></td>
                            <td><?php echo $row['diskusitype']; ?></td>
                            <td>
                                <a href="<?php echo site_url('Diskusi/DiskusiForm/'.$row['diskusiid']) ?>"
                                    class="btn btn-primary btn-circle btn-sm">
                                    <i class="fa fa-link"></i>
                                </a>
                                <button onclick="DeleteData('<?php echo $row['diskusiname'] ?>','<?php echo $row['diskusiid'] ?>')"
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
        type:'error',text:"Diskusi  : " + xusercode,
        showCancelButton: true,
        
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        buttonsStyling: true
    }, function () {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Diskusi/Delete') ?>",
                data: {
                    'diskusiid': xuserid
                },
                cache: false,
                success: function(response) {
                    console.log(response);
                    if(response['success']){
                        swal(
                        "Success!",
                        "Data telah terhapus!",
                        "success"
                    );
                    location.reload(); 
                    }
                    else {

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
        });
}
</script>
<!-- /.container-fluid -->