

<div class="container " >

        <!-- Page Heading -->
        <div class="row">

          <div class="col-lg-8">
            <center><?= $this->session->flashdata('aa');
              $this->session->userdata('email'); ?></center>
            <div class="p-5">
              <div class="text-left">
               <h1 class="page-header ">Edit
                    <small>Password</small>
                  </h1>
              </div>

                <?= form_open_multipart('Dashboard/EditPasswordKaryawan'); ?>
                
                <?php
                    foreach ($data->result_array() as $a) {
                        $username=$a['email_kar'];

                    ?>
        		
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" >Email</label>
                    <div class="col-sm-8">
                        <input name="email" class="form-control" type="text" value="<?php echo $username;?>" placeholder="Input Username..." style="width:280px;" readonly required>
                    </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-4 col-form-label">Password Lama</label>
                  <div class="col-sm-8">
                    <input type="password" name="current_password" class="form-control" id="inputPassword3" placeholder="Password">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-4 col-form-label">Password</label>
                  <div class="col-sm-8">
                    <input type="password" name="new_password1" class="form-control" id="inputPassword3" placeholder="Password">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-4 col-form-label">Ulangi Password</label>
                  <div class="col-sm-8">
                    <input type="password" name="new_password2" class="form-control" id="inputPassword3" placeholder="Password">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-8">
                    <button type="submit" class="btn btn-info">Simpan</button>
                    <a href="<?= base_url('Dashboard/Profile') ?>" class="btn btn-primary">Kembali</a>
                                  
                  </div>
                </div>

                	<?php } ?>
                 <?= form_close(); ?>

        </div>
        </div>

    </div>
