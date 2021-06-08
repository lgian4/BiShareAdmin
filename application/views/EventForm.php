<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Event Form </h1>

    </div>
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="text-center text-danger">
                <?php echo $error ?>
            </div>
            <form action="<?php echo site_url('Event/Save') ?>" method="post">
                <input type="hidden" name="eventid" value="<?php echo $event['eventid'] ?>" />             
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" name="eventnama" class="form-control"
                            value="<?php echo $event['eventnama'] ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Code</label>
                    <div class="col-sm-10">
                        <input type="text" name="eventcode" class="form-control"
                            value="<?php echo $event['eventcode'] ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'textarea',
                            'id' => 'eventdesc',
                            'name' => 'eventdesc',
                            'class' => 'form-control',
                            'placeholder' => 'Isi deksripsi',
                           'required'=>'',
                            'value'=> $event['eventdesc']
                            );
                            echo form_textarea($formcontrol);
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <?php 
                     $options = array('' => 'Pilih salah satu',);
                     
                         $options["aktif"] = "Aktif";
                         $options["nonaktif"] = "Non-Aktif";
                     
                    echo form_dropdown('status', $options, $event['status'],'class="form-control required"');
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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Produk Berpartisipasi</h1>

    </div>
    <div class="card shadow mb-4">
        <div class="card-header ">
            <div class="text-center text-danger">
                <?php echo $error ?>
            </div>
            <form action="<?php echo site_url('Event/SaveProduk') ?>" method="post">
            <input type="hidden" name="eventid" value="<?php echo $event['eventid'] ?>" required/>             
            <div class="row mb-3">
            
                    <label class="col-sm-2 col-form-label">Tambah Produk</label>
                    <div class="col-sm-8">
                        <?php 
                     $options = array('' => 'Pilih salah satu',);
                     foreach($produk as $row):
                        $options[$row['produkid']] =$row['produkcode'] ." | ".$row['produkname'] ." | ".$row['tokoname'];
                     endforeach;
                     
                    echo form_dropdown('produkid', $options, '','class="form-control required"');
                     ?>

                    </div>
                    <button type="submit" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text">Add</span>
                </button>
                </div>
           
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            
                            <th>Code</th>
                            <th>Nama</th>
                            <th>Toko</th>
                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i= 1; ?>
                        <?php foreach($eventdetail as $row): ?>

                        <tr>
                            <?php if($row['dlt']) continue; ?>
                            <td><?php echo $i++; ?></td>

                          
                            <td><?php echo $row['produkcode']; ?></td>
                            <td><?php echo $row['produkname']; ?></td>
                            <td><?php echo $row['tokoname']; ?></td>                            
                            
                            <td>
                                
                                <button onclick="DeleteData('<?php echo $row['produkname'] ?>','<?php echo $row['produkid'] ?>','<?php echo $event['eventid'] ?>')"
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
function DeleteData(xusercode, xuserid,xeeventid) {
    swal({
        title: "Apakah anda yakin untuk menghapus",
        type:'error',text:"Event Produk  : " + xusercode,
        showCancelButton: true,
        
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        buttonsStyling: true
    }, function () {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Event/DeleteProduk') ?>",
                data: {
                    'produkid': xuserid,
                    'eventid':xeeventid
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