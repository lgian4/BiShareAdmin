<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Diskusi Form </h1>

    </div>
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="text-center text-danger">
                <?php echo $error ?>
            </div>
            <form action="<?php echo site_url('Diskusi/Save') ?>" method="post">
                <input type="hidden" name="diskusiid" value="<?php echo $diskusi['diskusiid'] ?>" />             
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" name="diskusiname" class="form-control"
                            value="<?php echo $diskusi['diskusiname'] ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'textarea',
                            'id' => 'diskusidesc',
                            'name' => 'diskusidesc',
                            'class' => 'form-control',
                            'placeholder' => 'Isi deksripsi',
                           'required'=>'',
                            'value'=> $diskusi['diskusidesc']
                            );
                            echo form_textarea($formcontrol);
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-10">
                        <?php 
                     $options = array('' => 'Pilih salah satu',);
                     
                         $options["toko"] = "Toko";
                         $options["user"] = "User";
                     
                    echo form_dropdown('diskusitype', $options, $diskusi['diskusitype'],'class="form-control required"');
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