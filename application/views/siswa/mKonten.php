<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 <?php foreach ($tugas as $key) {
      ?>
      <div class="modal fade" id="subTugas<?php echo $key->id_tugas; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Submit Tugas</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
              <div class="form-group">
                <label>Status : </label>
                <?php 
                if ($key->jawaban_tugas!=null) {
                  switch ($key->jawaban_tugas['st']) { //1proses, -1 salah, 2benar
                      case '1':
                         ?><p style="color: #FAA41A;">Jawaban Sedang Di Proses</p> <?php
                         break;
                      case 'AC':
                         ?><p style="color: green;">Jawaban Benar</p> 
                         <label>File tugas sebelumnya :</label>
                            <a href="<?php echo base_url('jawaban_tugas/'.$key->jawaban_tugas['file_jawaban']); ?>" download>
                              <?php echo $key->jawaban_tugas['file_jawaban']; ?></a>
                            <?php
                         break;
                      case 'WA':
                         ?><p style="color: red;">Jawaban salah</p> 
                           <?php echo form_open_multipart("Siswa/jawab_tugas/".$key->jawaban_tugas['id_jawaban_tugas']);
                          ?>
                            <label>File tugas sebelumnya :</label>
                            <a href="<?php echo base_url('jawaban_tugas/'.$key->jawaban_tugas["file_jawaban"]); ?>" download><?php echo $key->jawaban_tugas['file_jawaban']; ?></a>
                            <label>File tugas upload :</label>
                            <input class="form-control" type="file" name="file"/>
                            <input type="hidden" name="namafile" value="<?php echo $key->jawaban_tugas['file_jawaban']; ?>">
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                           <?php echo form_close(); ?>
                         <?php
                         break;
                        case 'nodata':
                            ?><p style="color: #FAA41A;">Pending...</p> 
                            <p>Silahkan Refresh page</p>
                            <button class="btn btn-success" onClick="window.location.reload();">Refresh Page</button>
                            <?php
                           break;
                      case 'CE':
                         ?><p style="color: red;">Compile Error!</p> 
                          <?php
                          $id_jawaban_tugas =  $key->jawaban_tugas["id_jawaban_tugas"];
                          echo form_open_multipart('Siswa/jawab_tugas/'.$id_jawaban_tugas);
                          ?>
                            <label>File tugas sebelumnya :</label>
                            <a href="<?php echo base_url('jawaban_tugas/'.$key->jawaban_tugas["file_jawaban"]); ?>" download><?php echo $key->jawaban_tugas['file_jawaban']; ?></a>
                            <label>File tugas upload :</label>
                            <input class="form-control" type="file" name="file"/>
                            <input type="hidden" name="namafile" value="<?php echo $key->jawaban_tugas['file_jawaban']; ?>">
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                           <?php echo form_close(); ?>
                         <?php
                         break;
                     }
                     ?>

                       <?php
                      }else {
                   ?>
                   <p style="color: red;">Belum dikerjakan</p>

                    <?php echo form_open_multipart("Siswa/jawab_tugas");
                  ?>
                    <label>File tugas upload :</label>
                    <input class="form-control" type="file" name="file"/>
                    <input type="hidden" name="id_tugas" value="<?php echo $key->id_tugas; ?>">
                    <input type="hidden" name="id_problem" value="<?php echo $key->id_problem; ?>">
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                   <?php echo form_close(); ?>

                   <?php
                  }
                 ?>
               
            </div>
          </div>
        </div>
      </div>
      <?php
      }
      ?>
  </div>