
    <div class="row mb-2">
        <h2><?php echo "$nama_topik"; ?></h2>                                    
    </div>  
 <div class="row">
   <div style="height: 80vh;">
   </div>
        <iframe style="background-color: white;" src="<?php echo site_url('Siswa/load_konten/'); echo"$id_topik/$page/2"; ?>" class="col col-md-4">
        </iframe> 
        <iframe style="background-color: white;" src="<?php echo site_url('Siswa/load_konten/'); echo"$id_topik/$page/2"; ?>" class="col col-md-4">
        </iframe> 
        <iframe style="background-color: white;" src="<?php echo site_url('Siswa/load_konten/'); echo"$id_topik/$page/3"; ?>" class="col col-md-4">
        </iframe> 
  </div>
                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner ">
                                <div class="justify-content-center align-items-center">
                                    <?php if ($page>1) {
                                        $pages=$page-1;
                                        ?>
                                        <a class="btn btn-primary" href="<?php echo site_url("Siswa/sesi/$nama_sesi/$nama_topik/$pages") ?>">back</a>
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
                                        <a class="btn" href="<?php echo site_url("Siswa/sesi/$nama_sesi/$nama_topik/$i") ?>"><font style="color: blue;"><?php echo $i;?></font></a>
                                        <?php
                                      }
                                      ?>

                                      <?php
                                    } ?>

                                  <?php if ($page<$total_page) {
                                        $pagess=$page+1;
                                        ?>
                                        <a class="btn btn-primary" href="<?php echo site_url("Siswa/sesi/$nama_sesi/$nama_topik/$pagess") ?>">next</a>
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
