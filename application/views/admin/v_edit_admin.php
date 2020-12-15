
        <!-- Begin Page Content -->
        <div class="container">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
           <div class="row">
            <div class="col-lg-6">
              <?= $this->session->flashdata('aa');
              $this->session->userdata('email'); ?>
            </div>
          </div>

          <div class="row">
          	<div class="col-lg-8">
          		<?= form_open_multipart('Dashboard/EditProfileAdmin'); ?>
          		<?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['id'];
                        $nm=$a['name'];
                        $username=$a['email'];
                        $gmbr=$a['image'];
                        $created=$a['date_created'];
                ?>
					<div class="form-group row">
					    <label for="email" class="col-sm-2 col-form-label">Email</label>
					    <div class="col-sm-10">
					      <input type="email" class="form-control" id="email" name="email" >
					      <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
					    </div>
					</div>
          			<div class="form-group row">
					    <label for="name" class="col-sm-2 col-form-label">Full Name</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="name" name="name" >
					      <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>

					    </div>
					</div>
					<div class="form-group row">
					  	<div class="col-sm-2">Gambar</div>
					  	<div class="col-sm-10">
					  		<div class="row">
					  			<div class="col-sm-3">
					  				<img src="<?= base_url('assets/img/profile/') . $gmbr; ?>" class="img-thumbnail">
					  			</div>
					  			<div class="col-sm-9">
									<div class="custom-file">
									  <input type="file" name="image" class="form-control " id="inputimage">
									</div>
					  			</div>
					  		</div>
					  	</div>
					</div>

					<div class="form-group row justify-content-end">
						<div class="col-sm-10">
							<button type="submit" class="btn btn-primary">Edit</button>
							<a class="btn btn-success" href="<?= base_url('Dashboard/Profile'); ?>" title="Edit"> kembali</a>
						</div>
					</div>
					<?php endforeach;?>
          		</form>
          	</div>
          </div>
          	
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
