<div class="container">
<h3>Daftar Sesi</h3>	
<button type="button" style="float: right;" class="btn btn-primary fa fa-plus-circle" data-toggle="modal" data-target="#addSesi">
  Tambah Sesi
</button>
<ul>
	<?php
	foreach ($sesi as $key) {
	?>
	<li><a href="<?php echo site_url('Admin/sesi/');echo $key->nama_sesi?>"><?php echo "$key->nama_sesi"; ?></a></li>
	<?php
	}
	?>
</ul>
</div>



