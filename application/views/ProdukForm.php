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
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <input type="text" name="status" class="form-control" value="<?php echo $produk['status'] ?>"
                            readonly>
                    </div>
                </div>
                <?php if($status != 'admin' || $produk['produkid'] != '') {?>
                <input type="hidden" name="tokoid" value="<?php echo $produk['tokoid'] ?>" />
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Toko</label>
                    <div class="col-sm-10">
                        <input type="text" name="tokoname" class="form-control"
                            value="<?php echo $produk['tokoname'] ?>" readonly>
                    </div>
                </div>
                <?php }else{?>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Toko</label>
                    <div class="col-sm-10">
                        <?php 
                     $options = array('' => 'Pilih salah satu',);
                     foreach ($toko as $key => $value) {
                         $options[$value['tokoid']] = $value['tokoname'];
                     }
                    echo form_dropdown('tokoid', $options, $produk['tokoid'],'class="form-control required"');
                     ?>

                    </div>
                </div>
                <?php }?>
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
                    <label class="col-sm-2 col-form-label">Video Youtube</label>
                    <div class="col-sm-10">
                        <input type="text" name="youtubevideo" class="form-control"
                            value="<?php echo $produk['youtubevideo'] ?>" >
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
                        <input type="file" name="uploadfile" class="form-control" accept="image/*" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary  btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="text">Upload</span>
                </button>
            </form>
      </div>
        <div class="card-header">
            <h4 id="medialist">Produk Media</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Type</th>
                            <th>Ext</th>
                            <th>Size</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i= 1; ?>
                        <?php foreach($produk['produkmedia'] as $row): ?>

                        <tr>
                            <?php if( $row == null || $row['dlt'] ) continue; ?>
                            <td><?php echo $i++; ?></td>

                            <td><?php echo $row['medianama']; ?></td>
                            <td><?php echo $row['mediatype']; ?></td>
                            <td><?php echo $row['mediaext']; ?></td>
                            <td><?php echo $row['mediasize']; ?></td>
                            <td><?php echo $row['mediadate']; ?></td>

                            <td>
                                <a href="<?php echo $row['mediaurl'] ?>" target="_blank"
                                    class="btn btn-primary btn-circle btn-sm">
                                    <i class="fa fa-link"></i>
                                </a>
                                <button
                                    onclick="DeleteMedia('<?php echo $row['medianama'] ?>','<?php echo $row['mediaid'] ?>')"
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
        <?php }?>
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
function DeleteMedia(xusercode, xuserid) {
    swal({
        title: "Apakah anda yakin untuk menghapus",
        type:'error',text:"Nama File : " + xusercode,
        showCancelButton: true,
        
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        buttonsStyling: true
    },function() {
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