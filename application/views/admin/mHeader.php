<!-- Modal Tambah Sesi -->
<!-- Button trigger modal -->


<!-- Modal -->

<?php foreach ($sesi as $key) {
  ?>
  <div class="modal fade" id="addTopic<?php echo $key->id_sesi;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo site_url('Admin/tambah_topik')?>">
          <div class="form-group">
            <label for="nama_topik">Nama Topik</label>
            <input type="text" class="form-control" id="nama_topik"  name="nama_topik">
            <input type="hidden" name="id_sesi" value="<?php echo $key->id_sesi;?>">
            <input type="hidden" name="nama_sesi" value="<?php echo $key->nama_sesi;?>">
          </div>
          <button type="submit" class="btn btn-primary">Tambah</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
} 
?>