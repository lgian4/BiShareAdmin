<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Form </h1>

    </div>
    <div class="card shadow mb-4">

        <div class="card-body">
        <div class="text-center text-danger">
                <?php echo $error ?>
            </div>
            <form action="<?php echo site_url('User/Save') ?>" method="post">
                <input type="hidden" name="userid" value="<?php echo $user['userid'] ?>" />
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <input type="text" name="status" class="form-control" value="<?php echo $user['status'] ?>"
                            readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Code</label>
                    <div class="col-sm-10">
                        <input type="text" name="usercode" class="form-control" value="<?php echo $user['usercode'] ?>"
                            readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Date</label>
                    <div class="col-sm-10">
                        <input type="date" name="userdate" class="form-control" value="<?php echo $user['userdate'] ?>"
                            readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama" class="form-control" value="<?php echo $user['nama'] ?>"
                            required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                        <?php 
                     $options = array(
                        ''         => 'Pilih salah satu',
                        'm'         => 'Male',
                        'f'           => 'Female',
                    );
                    echo form_dropdown('jeniskelamin', $options, $user['jeniskelamin'],'class="form-control"');
                     ?>
                     
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <?php 
                        $date = array(
                            'type' => 'date',
                            'id' => 'tanggallahir',
                            'name' => 'tanggallahir',
                            'class' => 'form-control',
                            'placeholder' => 'dd/mm/yyyy',
                            'required' => '',
                            'value'=> $user['tanggallahir']
                            );
                            echo form_input($date);
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">No HP</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'text',
                            'id' => 'nohp',
                            'name' => 'nohp',
                            'class' => 'form-control',
                            'placeholder' => 'No HP',
                            'required' => '',
                            'value'=> $user['nohp']
                            );
                            echo form_input($formcontrol);
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'email',
                            'id' => 'email',
                            'name' => 'email',
                            'class' => 'form-control',
                            'placeholder' => 'Isi email',
                            'required' => '',
                            'value'=> $user['email']
                            );
                            echo form_input($formcontrol);
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'textarea',
                            'id' => 'alamat',
                            'name' => 'alamat',
                            'class' => 'form-control',
                            'placeholder' => 'Isi Alamat',
                           
                            'value'=> $user['alamat']
                            );
                            echo form_textarea($formcontrol);
                        ?>
                    </div>
                </div>
              
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'text',
                            'id' => 'username',
                            'name' => 'username',
                            'class' => 'form-control',
                            'placeholder' => 'Isi username',
                            'required' => '',
                            'value'=> $user['username']
                            );
                            echo form_input($formcontrol);
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <?php 
                        $formcontrol = array(
                            'type' => 'password',
                            'id' => 'password',
                            'name' => 'password',
                            'class' => 'form-control',
                            'placeholder' => 'Isi password',
                            'required' => '',
                            'value'=> $user['password']
                            );
                            echo form_input($formcontrol);
                        ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-success  btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-save"></i>
                                        </span>
                                        <span class="text">Save</span>
                                    </button>
                                    <?php  if( (!isset($user['tokoid']) || $user['tokoid'] == '') &&  $user['status'] == 'customer'){ $user['tokoid'] ='' ;?>

<a href="<?php echo site_url('Toko/TokoForm/'.$user['userid'].'/'. $user['tokoid'] ) ?>" class="btn btn-primary  btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-store"></i>
                </span>
                <span class="text">Request Buka Toko</span>
            </a>

<?php }?>
<?php if( $user['tokoid'] !== '' &&  $user['status'] == 'customer'){?>

<a href="<?php echo site_url('Toko/TokoForm/'.$user['userid'].'/'. $user['tokoid'] ) ?>" class="btn btn-primary  btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-store"></i>
            </span>
            <span class="text">Cek Toko Request</span>
        </a>

<?php }?>
<?php if( $user['tokoid'] != '' &&  $user['status'] == 'penjual'){?>

<a href="<?php echo site_url('Toko/TokoForm/'.$user['userid'].'/'. $user['tokoid'] ) ?>" class="btn btn-primary  btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-store"></i>
            </span>
            <span class="text">Buka Toko</span>
        </a>

<?php }?>
               
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