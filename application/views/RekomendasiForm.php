<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rekomendasi Form </h1>

    </div>
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="text-center text-danger">
                <?php echo $error ?>
            </div>
            <form action="<?php echo site_url('rekomendasi/Save') ?>" method="post">
                <input type="hidden" name="rekomendasiid" value="<?php echo $rekomendasi['rekomendasiid'] ?>" />

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">ID</label>
                    <div class="col-sm-10">
                        <input type="text" name="status" class="form-control" value="<?php echo $rekomendasi['rekomendasiid'] ?>"
                            readonly>
                    </div>
                </div>
            
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Produk</label>
                    <div class="col-sm-10">
                        <?php 
                     $options = array('' => 'Pilih salah satu',);
                     foreach ($produk as $key => $value) {
                         $options[$value['produkid']] = $value['produkname'];
                     }
                    echo form_dropdown('produkid', $options, $rekomendasi['produkid'],'class="form-control required"');
                     ?>

                    </div>
                </div>                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Urutan</label>
                    <div class="col-sm-10">
                        <input type="number" name="urutan" class="form-control"
                            value="<?php echo $rekomendasi['urutan'] ?>" required>
                    </div>
                </div>
                


                <button type="submit" class="btn btn-success  btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text">Save</span>
                </button>


                <hr>

            </form>
        </div>
    </div>



</div>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();

});
function DeleteMedia(xusercode, xuserid) {
    swal.fire({
        title: "Apakah anda yakin untuk menghapus",
        icon: 'error',
        text:"Nama File : " + xusercode,
        showCancelButton: true,
        
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        buttonsStyling: true
    }).then(function() {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Produk/DeleteMedia') ?>",
                data: {
                    'mediaid': xuserid,
                    'produkid': <?php echo $produk['produkid'] ?>,
                },
                cache: false,
                success: function(response) {
                    console.log(response);
                    if(response['success']){
                        swal.fire(
                        "Success!",
                        "Data telah terhapus!",
                        "success"
                    );
                    location.reload(); 
                    }
                    else {

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