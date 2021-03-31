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
                <input type="hidden" name="produkid" value="<?php echo $produk['tokoid'] ?>" />
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <input type="text" name="status" class="form-control" value="<?php echo $produk['status'] ?>"
                            readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Toko</label>
                    <div class="col-sm-10">
                        <input type="text" name="tokoname" class="form-control"
                            value="<?php echo $produk['tokoname'] ?>" readonly>
                    </div>
                </div>
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
                    <label class="col-sm-2 col-form-label">Date</label>
                    <div class="col-sm-10">
                        <input type="text" name="produkdate" class="form-control"
                            value="<?php echo $produk['produkdate'] ?>" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                        <?php 
                     $options = array('' => 'Pilih salah satu',);
                     foreach ($kategori as $key => $value) {
                         $options[$value['kategoriid']] = $value['kategoriname'];
                     }
                    echo form_dropdown('kategoriid', $options, $produk['kategoriid'],'class="form-control required"');
                     ?>

                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input type="number" name="harga" class="form-control" value="<?php echo $produk['harga'] ?>"
                            required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Stok</label>
                    <div class="col-sm-10">
                        <input type="number" name="stok" class="form-control" value="<?php echo $produk['stok'] ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'textarea',
                            'id' => 'deskripsi',
                            'name' => 'deskripsi',
                            'class' => 'form-control',
                            'placeholder' => 'Isi deksripsi',
                           'required'=>'',
                            'value'=> $produk['deskripsi']
                            );
                            echo form_textarea($formcontrol);
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Fitur</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'textarea',
                            'id' => 'fitur',
                            'name' => 'fitur',
                            'class' => 'form-control',
                            'placeholder' => 'Isi fitur',
                           
                            'value'=> $produk['fitur']
                            );
                            echo form_textarea($formcontrol);
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Spesifikasi</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'textarea',
                            'id' => 'spesifikasi',
                            'name' => 'spesifikasi',
                            'class' => 'form-control',
                            'placeholder' => 'Isi spesifikasi',
                           
                            'value'=> $produk['spesifikasi']
                            );
                            echo form_textarea($formcontrol);
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Alasan</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'textarea',
                            'id' => 'alasan',
                            'name' => 'alasan',
                            'class' => 'form-control',
                            'placeholder' => 'Isi alasan',
                           'readonly'=>'',
                            'value'=> $produk['alasan']
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
        <?php if( $produk['produkid']!= '') {?>
        <div class="card-header">
            <h4>Upload Media</h4>
        </div>
        <div class="card-body">
            <div class="text-center text-danger">
                <?php echo $error ?>
            </div>
            <form action="<?php echo site_url('produk/UploadMedia') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="produkid" value="<?php echo $produk['produkid'] ?>" />
                

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">File</label>
                    <div class="col-sm-10">
                        <input type="file" name="uploadfile" class="form-control" accept="image/*,video/*"
                           required>
                    </div>
                </div>
              
                <button type="submit" class="btn btn-primary  btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="text">Upoad</span>
                </button>
            </form>
        </div><?php }?>
        <?php if($status =='admin' && $produk['produkid']!= '') {?>
        <div class="card-header">
            <h4>Review</h4>
        </div>
        <div class="card-body">
            <div class="text-center text-danger">
                <?php echo $error ?>
            </div>
            <form action="<?php echo site_url('produk/Review') ?>" method="post">
                <input type="hidden" name="produkid" value="<?php echo $produk['produkid'] ?>" />
                <input type="hidden" name="tokoid" value="<?php echo $produk['tokoid'] ?>" />

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Alasan</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'textarea',
                            'id' => 'alasan',
                            'name' => 'alasan',
                            'class' => 'form-control',
                            'placeholder' => 'Isi alasan',
                           'required'=>'',
                            'value'=> $produk['alasan']
                            );
                            echo form_textarea($formcontrol);
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Review</label>
                    <div class="col-sm-10">
                        <?php 
                     $options = array(
                        ''         => 'Pilih salah satu',
                        'approve'         => 'Approve',
                        'reject'           => 'Reject',
                    );
                    echo form_dropdown('status', $options, $produk['status'],'class="form-control" required');
                     ?>

                    </div>
                </div>
                <button type="submit" class="btn btn-warning  btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Review</span>
                </button>
            </form>
        </div><?php }?>
    </div>



</div>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();

});
</script>
<!-- /.container-fluid -->