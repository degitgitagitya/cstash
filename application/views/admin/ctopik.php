<div class="page-title-wrapper">
    <div class="page-title-heading container">
        <h2><?php echo "$nama_topik"; ?></h2>                                    
    </div>
    <div class="container" style="padding-bottom: 10px;">
      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editTopik">Edit Nama Topik</button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahKonten">Tambah Konten</button>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editKonten">Edit Konten</button>
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteKonten">Hapus Konten</button>
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambahTugas">Tambah Tugas</button>
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusTugas">Hapus Tugas</button>
    </div>
  
</div>
  <div class="row container">
        <iframe style="background-color: white;" src="<?php echo site_url('Admin/load_konten/'); echo"$id_topik/$page/1"; ?>" class="col col-md-4" height="400vh">
        </iframe> 
        <iframe style="background-color: white;" src="<?php echo site_url('Admin/load_konten/'); echo"$id_topik/$page/2"; ?>" class="col col-md-4" height="400vh">
        </iframe> 
        <iframe style="background-color: white;" src="<?php echo site_url('Admin/load_konten/'); echo"$id_topik/$page/3"; ?>" class="col col-md-4" height="400vh">
        </iframe> 
  </div>
</div>
                    </div>
                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner ">
                                <div class="justify-content-center align-items-center">
                                    <?php if ($page>1) {
                                        $pages=$page-1;
                                        ?>
                                        <a class="btn btn-primary" href="<?php echo site_url("Admin/sesi/$nama_sesi/$nama_topik/$pages") ?>">back</a>
                                        <?php       
                                    }else{
                                      ?>
                                      <button class="btn btn-primary" disabled>back</button>
                                      <?php
                                    } ?>

                                    <?php 
                                    for($i=1;$i<=$total_page;$i++){ 
                                      if ($i==$page) {
                                        ?>
                                        <button class="btn" disabled href="#"><?php echo $i;?></button>
                                        <?php
                                      }else{
                                        ?>
                                        <a class="btn" href="<?php echo site_url("Admin/sesi/$nama_sesi/$nama_topik/$i") ?>"><font style="color: blue;"><?php echo $i;?></font></a>
                                        <?php
                                      }
                                      ?>

                                      <?php
                                    } ?>

                                  <?php if ($page<$total_page) {
                                        $pagess=$page+1;
                                        ?>
                                        <a class="btn btn-primary" href="<?php echo site_url("Admin/sesi/$nama_sesi/$nama_topik/$pagess") ?>">next</a>
                                        <?php       
                                    }else{
                                      ?>
                                      <button class="btn btn-primary" disabled>next</button>
                                      <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
        </div>
    </div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="editKonten" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo site_url('Admin/eKonten'); ?>">
         <input type="hidden" name="id_konten" value="<?php echo $id_konten ;?>">
         <div class="form-group">
            <label>Judul1</label>
            <input type="text" class="form-control" name="judul1" value="<?php echo($judul1)?>" required>
          </div>
          <div class="form-group">
            <label>Konten1</label>
            <textarea class="form-control" rows="2" name="konten1" required><?php echo($konten1) ?></textarea>
          </div>
          <div class="form-group">
            <label>Judul2</label>
            <input type="text" class="form-control" name="judul2" value="<?php echo($judul2) ?>" required>
          </div>
          <div class="form-group">
            <label>Konten2</label>
            <textarea class="form-control" rows="2" name="konten2" required> <?php echo($konten2)?></textarea>
          </div>
          <div class="form-group">
            <label>Judul3</label>
            <input type="text" class="form-control" name="judul3" value="<?php echo($judul3) ?>" required>
          </div>
          <div class="form-group">
            <label>Konten3</label>
            <textarea class="form-control" rows="2" name="konten3" required><?php echo($konten3) ?></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Edit</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteKonten" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Konten</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Hapus Konten?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a class="btn btn-danger" href="<?php echo site_url('Admin/hapus_konten/'); echo $id_konten; ?>" >Hapus</a>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="hapusTugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Tugas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Hapus semua tugas pada konten ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a class="btn btn-danger" href="<?php echo site_url("Admin/hapus_konten/$id_konten/tugas");?>" >Hapus</a>
        </form>
      </div>
    </div>
  </div>
</div>

 <!-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editTopik">Edit Nama Topik</button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahKonten">Tambah Konten</button>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editKonten">Edit Konten</button>
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteKonten">Hapus Konten</button>
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambahTugas">Tambah Tugas</button> -->
<div class="modal fade" id="editTopik" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="POST" action="<?php echo site_url('Admin/eTopik')?>">
         <input type="hidden" name="id_topik" value="<?php echo $id_topik ;?>">
         <input type="hidden" name="nama_sesi" value="<?php echo $nama_sesi ;?>">
         <input type="hidden" name="page" value="<?php echo $page ;?>">
         <input type="hidden" name="mode" value="1">
         <div class="form-group">
            <label>Nama Topik</label>
            <input type="text" class="form-control" name="nama_topik" value="<?php echo($nama_topik)?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Edit</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="tambahKonten" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Konten</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('Admin/tambah_konten');
        ?>
        <div class="form-group">
         <input type="hidden" name="nama_sesi" value="<?php echo $nama_sesi;?>">
         <input type="hidden" name="nama_topik" value="<?php echo $nama_topik;?>">
         <input type="hidden" name="id_topik" value="<?php echo $id_topik;?>">

        <label>Judul1</label>
            <input type="text" class="form-control" name="judul1" required>
          </div>
          <div class="form-group">
            <label>Isi Konten 1</label>
            <textarea class="form-control" rows="2" name="konten1" required></textarea>
          </div>
          <div class="form-group">
            <label>Judul2</label>
            <input type="text" class="form-control" name="judul2" required>
          </div>
          <div class="form-group">
            <label>Isi Konten 2</label>
            <textarea class="form-control" rows="2" name="konten2" required></textarea>
          </div>
          <div class="form-group">
            <label>Judul3</label>
            <input type="text" class="form-control" name="judul3" required>
          </div>
          <div class="form-group">
            <label>Isi Konten 3</label>
            <textarea class="form-control" rows="2" name="konten3" required></textarea>
          </div>
           <div class="form-group">
            <label>Tugas</label>
            <textarea class="form-control" rows="2" name="isi_tugas" placeholder="Deskripsi tugas"></textarea>
            <label>File tugas upload :</label>
            <input class="form-control" type="file" name="file"/>
            <input class="form-control" type="text" name="nama_file" placeholder="Nama File Tugas">
            <label>Problem</label>
            <select id="inputState" class="form-control" name="id_problem">
              <option selected>Choose...</option>
              <?php
              foreach ($problem as $key) {
               ?>
                <option value="<?php echo $key['id']; ?>">p<?php echo $key['id']."-".$key['name']; ?></option>
               <?php
              }
              ?>
            </select>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        <?php echo form_close(); 
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="tambahTugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Tugas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart("Admin/tambah_tugas/$id_konten/$page/$id_topik");
        ?>
         <div class="form-group">
            <label>Tugas</label>
            <textarea class="form-control" rows="2" name="isi_tugas" placeholder="Deskripsi tugas"></textarea>
            <label>File tugas upload :</label>
            <input class="form-control" type="file" name="file"/>
            <input class="form-control" type="text" name="nama_file" placeholder="Nama File Tugas">
            <input type="hidden" name="nama_sesi" value="<?php echo $nama_sesi;?>">
            <label>Problem</label>
            <select id="inputState" class="form-control" name="id_problem">
              <option selected>Choose...</option>
              <?php
              foreach ($problem as $key) {
               ?>
                <option value="<?php echo $key['id']; ?>">p<?php echo $key['id']."-".$key['name']; ?></option>
               <?php
              }
              ?>
            </select>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
         <?php echo form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        
      </div>
    </div>
  </div>
</div>