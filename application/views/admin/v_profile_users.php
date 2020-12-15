


        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <div class="row">
            <div class="col-lg-6">
              <?= $this->session->flashdata('aa');
              $this->session->userdata('email'); ?>
            </div>
          </div>
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

          <div class="card mb-3 col-lg-8" >
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="<?php echo base_url('assets/img/profile/') . $gmbr; ?>" class="card-img" >
              </div>
              <div class="col-md-8">
               
                <div class="card-body">
                  <h5 class="card-title"><?= $nm;; ?></h5>
                  <p class="card-text"><?= $username; ?></p>
                  <p class="card-text"><small class="text-muted">Menjadi member sejak  <?= date( $_SESSION['tgl']);  ?></small></p>

                  <a class="btn btn-sm btn-xs btn-warning" href="<?= base_url('Dashboard/editProfileUser'); ?>" title="Edit"><span class="fa fa-edit"></span> Edit</a>
                  <a class="btn btn-sm btn-xs btn-success" href="<?= base_url('Dashboard/EditPasswordUser'); ?>" title="Edit"><span class="fa fa-edit"></span> Edit Password</a>
                </div>

              </div>
            </div>
          </div>
        <?php endforeach;?>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


      
