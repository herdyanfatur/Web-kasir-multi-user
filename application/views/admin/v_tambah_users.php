

  <div class="container">

        <!-- Page Heading -->
        <div class="row">

          <div class="col-lg-8">
            <div class="p-5">
              <div class="text-left">
               <h1 class="page-header ">Tambah
                    <small>Users</small>
                  </h1>
              </div>

                <?= form_open_multipart('adminn/users/tambah_users'); ?>
              <!--  -->
                <div class="form-group row">
                  <label for="nama" class="col-sm-4 col-form-label">Nama Lengkap</label>
                  <div class="col-sm-8">
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" value="<?= set_value('nama'); ?>">
                    <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-4 col-form-label">Email</label>
                  <div class="col-sm-8">
                    <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" value="<?= set_value('email'); ?>">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-4 col-form-label">Password</label>
                  <div class="col-sm-8">
                    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-4 col-form-label">Ulangi Password</label>
                  <div class="col-sm-8">
                    <input type="password" name="password2" class="form-control" id="inputPassword3" placeholder="Password">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-4 col-form-label">Gambar</label>
                  <div class="col-sm-8">
                    <div class="row">
                      <div class="col-sm-3">

                        <img src="<?= base_url('assets/img/profile/default.jpg') ?>" class="img-thumbnail"><!--  users[] di ganti users -->
                      </div>
                    <div class="col-sm-9">
                      <div class="custom-file">
                      <input type="file" name="image" class="form-control " id="inputimage">
                     
                      </div>
                    </div>
                    </div>
                    </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-8">
                    <button type="submit" class="btn btn-info">Simpan</button>
                    <a href="<?= base_url('adminn/users') ?>" class="btn btn-primary">Kembali</a>
                                  
                  </div>
                </div>
              <?= form_close(); ?>

        </div>
        </div>
    </div>