

    
    <!-- Custom CSS -->
    
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">


    <!-- Navigation -->

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
            <center><?php echo $this->session->flashdata('msg');?></center>
                <h1 class="page-header">Data
                    <small>karyawan</small>
                    <div class="float-right"><a href="<?= base_url('adminn/karyawan/tambah_karyawan'); ?>" class="btn btn-sm btn-success" ><span class="fa fa-plus "></span> Tambah karyawan</a></div>
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
            <table class="table table-bordered" style="font-size:11px;" id="mydata">
                <thead>
                    <tr>
                        <th style="text-align:center;width:40px;">No</th>
                        <th style="width:200px;height: 20px;">Nama</th>
                        <th>Email</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th>Tanggal Terdaftar</th>

                        <th style="width:240px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['id_kar'];
                        $nm=$a['name_kar'];
                        $username=$a['email_kar'];
                        $gmbr=$a['image_kar'];
                        $status=$a['is_active'];
                        $created=$a['date_created'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $nm;?></td>
                        <td><?php echo $username;?></td>
                        <td><img src="<?php echo base_url('assets/img/profile/') . $gmbr; ?>" class="img-thumbnail text-center" style="width: 40pt;"></td>
                         <td><?php if($status==1){echo "Aktif";}else{ echo "Tidak Aktif";}?></td>
                        <td><?php echo $created;?></td>
                        <td style="text-align:center;">
                            
                            <a  class="btn btn-sm btn-xs btn-danger" href="#modalCoba<?php echo $id?>" data-toggle="modal" title="Hapus"><span class="fa fa-close"></span> Hapus</a>
                            <a  class="btn btn-sm btn-xs btn-success" href="#modalCobaStatus<?php echo $id?>" data-toggle="modal" title="Status"><span class="fa fa-close"></span> Status</a>
                            
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            </div>
        </div>
        <!-- /.row -->
        <!-- ============ MODAL status =============== -->
       <?php
                    foreach ($data->result_array() as $a) {
                        $id=$a['id_kar'];
                        $nm=$a['name_kar'];
                    ?>
         <div id="modalCobaStatus<?php echo $id?>" enctype="multipart/form-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel">Status Karyawan</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url(). 'adminn/karyawan/statuskaryawan'?>">
                        <div class="modal-body">
                           
                                 <div class="form-group row">
                                         <label class="col-sm-4 col-form-label" for="inlineFormCustomSelectPref">Status Karyawan</label>
                                         <div class="col-sm-8">
                                            <input name="kode" type="hidden" value="<?php echo $id; ?>">
                                        <select name="is_active" class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                                          <option selected>Status</option>
                                          <option value="1">Aktif</option>
                                          <option value="2">Non Aktif</option>
                                        </select>
                                        </div>
                                      </div>
                                        <div class="form-group row ">
                                          <div class="col-sm-8 float-right">
                                            <button type="submit" class="btn btn-info">Simpan</button>
                                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                                                          
                                          </div>
                                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
       

        <!--END MODAL-->

        <hr>

        



         <!-- ============ MODAL edit password =============== -->

        <!-- ============ MODAL HAPUS =============== -->
        <?php
                    foreach ($data->result_array() as $a) {
                        $id=$a['id_kar'];
                        $nm=$a['name_kar'];
                    ?>
         <div id="modalCoba<?php echo $id?>" enctype="multipart/form-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel">Hapus Karyawan</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url(). 'adminn/karyawan/hapus_karyawan'?>">
                        <div class="modal-body">
                            <p>Yakin mau menghapus karyawan <b><?php echo $nm;?></b>..?</p>
                                    <input name="kode" type="hidden" value="<?php echo $id; ?>">
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                            <button type="submit" class="btn btn-primary">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
       

        <!--END MODAL-->

        <hr>



    </div>
    <!-- /.container -->

    <!-- jQuery -->

    <!-- jQuery -->
    <script src="<?php echo base_url().'assets/js/jquery.js'?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTables.bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script>
   
