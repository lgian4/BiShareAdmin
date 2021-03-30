<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produk Form </h1>

    </div>
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="text-center text-danger">
                <?php echo $error ?>
            </div>
            <form action="<?php echo site_url('Produk/Save') ?>" method="post">
                <input type="hidden" name="produkid" value="<?php echo $produk['produkid'] ?>" />
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Code</label>
                    <div class="col-sm-10">
                        <input type="text" name="produkcode" class="form-control"
                            value="<?php echo $produk['produkcode'] ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" name="produkname" class="form-control"
                            value="<?php echo $produk['produkname'] ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'textarea',
                            'id' => 'produkdesc',
                            'name' => 'produkdesc',
                            'class' => 'form-control',
                            'placeholder' => 'Isi deksripsi',
                           'required'=>'',
                            'value'=> $produk['produkdesc']
                            );
                            echo form_textarea($formcontrol);
                        ?>
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
</script>
<!-- /.container-fluid -->