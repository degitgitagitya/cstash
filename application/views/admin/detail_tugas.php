
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
xmp{ white-space:pre-wrap; word-wrap:break-word; }
pre{ white-space:pre-wrap; word-wrap:break-word; }
</style>
<body>
	<div>
		<h4 style="padding-top: 8px;" >Detail Tugas</h4>
		<b>isi tugas : </b>
		<p><?php echo $tugas['isi_tugas']; ?></p>
		<b>File : </b>
		<a href="<?php echo base_url('tugas/'.$tugas['file']) ?>" download> <?php echo $tugas['file']; ?></a><br><br>
      	<button style="width: 70px; height: 30px; padding: 0px;" type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit"><span style="font-size: 13px; padding: 2px;" >Edit Tugas</span></button>
      	<br>
      	<br>
		<b>Status siswa : </b>
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Nama</th>
		      <th scope="col">NIS</th>
		      <th scope="col">Jawaban</th>
		      <th scope="col">Status</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php foreach ($jawaban_siswa as $key) {
		  	?>
		  	<tr>
		      <th scope="row"><?php echo $key->nama; ?></th>
		      <td><?php echo $key->nis; ?></td>
		      <td><a href="<?php echo base_url('jawaban_tugas/'.$key->file_jawaban); ?>" download><?php echo "$key->file_jawaban"; ?></a></td>
		      <td>
		      	<?php
		      	switch ($key->st) {
		      		case 'AC':
		      			?>
		      			<font color="green" >Benar</font>
		      			<?php
		      			break;
		      		case 'CE':
		      			?>
		      			<font color="red" >Error</font>
		      			<?php
		      			break;
		      		case 'WA':
		      			?>
		      			<font color="red" >Salah</font>
		      			<?php
		      			break;
		      		default:
		      			?>
		      			<font color="red" >Belum</font>
		      			<?php
		      			break;
		      	}
		      	?>
		      </td>
		    </tr>
		  	<?php
		  	}
		  	?>
		  </tbody>
		</table>
		<button class="btn btn-secondary" onclick="goBack()">< Kembali </button>

		<script>
		function goBack() {
		  window.history.back();
		}
		</script>
	</div>
</body>
</Html>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Tugas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart("Admin/edit_tugas/".$tugas['id_tugas']);
        ?>
         <div class="form-group">
            <label>Tugas</label>
            <textarea class="form-control" rows="2" name="isi_tugas" placeholder="Deskripsi tugas"><?php echo $tugas['isi_tugas']; ?></textarea>
            <label>File tugas upload :</label>
            <input class="form-control" type="file" name="file">
            <input class="form-control" type="text" name="nama_file" placeholder="Nama File Tugas">
            <label>Problem</label>
            <select id="inputState" class="form-control" name="id_problem">
              <option selected>Choose...</option>
              <?php
              foreach ($problem as $key) {
               if ($key['id']==$tugas['id_problem']) {
               	# code...
               ?>
                <option selected="selected" value="<?php echo $key['id']; ?>">p<?php echo $key['id']."-".$key['name']; ?></option>
               <?php
              	}else{
              		?>
              		<option value="<?php echo $key['id']; ?>">p<?php echo $key['id']."-".$key['name']; ?></option>
              		<?php
              	}
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