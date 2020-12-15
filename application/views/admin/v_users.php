

    
    <!-- Custom CSS -->
    
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">


    <!-- Navigation -->

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
            <center><?php echo $this->session->flashdata('msg');?>
                
            </center>
                <h1 class="page-header">Data
                    <small>users</small>
                    <div class="pull-right">
                       
                       <div class="pull-right"><a href="<?= base_url('adminn/users/tambah_users'); ?>" class="btn btn-sm btn-success" ><span class="fa fa-plus "></span> Tambah Users</a></div>
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
                        
                        <th>Tanggal Terdaftar</th>

                        <th style="width:240px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
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
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $nm;?></td>
                        <td><?php echo $username;?></td>
                        <td><img src="<?php echo base_url('assets/img/profile/') . $gmbr; ?>" class="img-thumbnail text-center" style="width: 40pt;"></td>
                        <td><?php echo $created;?></td>
                        <td style="text-align:center;">
                           
                            <a  class="btn btn-sm btn-xs btn-danger" href="#modalCoba<?php echo $id?>" data-toggle="modal" title="Hapus"><span class="fa fa-close"></span> Hapus</a>
                           
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            </div>
        </div>
        <!-- /.row -->
        <!-- ============ MODAL edit password =============== -->
        
       <!-- ============ MODAL ADD =============== -->

       

       
         
        <!-- ============ MODAL HAPUS =============== -->
        <?php
                    foreach ($data->result_array() as $a) {
                        $id=$a['id'];
                        $nm=$a['name'];
                    ?>
         <div id="modalCoba<?php echo $id?>" enctype="multipart/form-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel">coba</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url(). 'adminn/users/hapus_users'?>">
                        <div class="modal-body">
                            <p>Yakin mau menghapus users <b><?php echo $nm;?></b>..?</p>
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
   
