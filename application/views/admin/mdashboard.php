<!-- Modal Tambah Sesi -->
<div class="modal fade" id="addSesi" tabindex="-1" role="dialog" aria-labelledby="add sesi" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Sesi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body container">
        <form class="container" action="<?php echo site_url('Admin/addSesi'); ?>" method="POST">
          <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nama Sesi</label>
            <input type="text" class="form-control" name="namaSesi" id="sesinama" placeholder="Sesi" required>
          </div>
          <div class="form-group col-md-4">
            <label >Ikon</label>
            <input type="text" class="form-control" name="namaIkon" id="ikon" placeholder="fa-namaikon" required>
          </div>
          <div class="form-group col-md-2">
            <label>tampilan</label>
            <button class="btn btn-success" type="button" onclick="ceksesi()">cek</button>
          </div>
          <li id="codec" style="list-style: none;  padding-bottom: 10px;" class=""><a style="padding-left: 10px;" id="namase" value=""></a></li>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  var temp;
  var namasess;
  var codeic = "fa";
  function ceksesi() {
  namasess = document.getElementById("sesinama").value;
  document.getElementById("namase").innerHTML = namasess;
  temp=codeic;
  document.getElementById("codec").classList.toggle(temp);
  codeic=document.getElementById("ikon").value;
  document.getElementById("codec").classList.toggle(codeic);
  
  }
</script>
