<?php foreach ($topik as $key) {
	?>
<div class="modal fade" id="edit<?php echo $key->id_topik; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Edit Topik</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="<?php echo site_url('Admin/eTopik')?>">
					<div class="form-group">
						<label for="nama_topik">Nama Topik</label>
						<input type="text" class="form-control" id="nama_topik" value="<?php echo $key->nama_topik; ?>" name="nama_topik">
						<input type="hidden" name="id_topik" value="<?php echo $key->id_topik;?>">
					</div>
					<button type="submit" class="btn btn-primary">Ubah</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="hapus<?php echo $key->id_topik; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Edit Topik</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="<?php echo site_url('Admin/hapus_topik')?>">
					<div class="form-group">
						<label for="nama_topik">Hapus <?php echo $key->nama_topik;?>? </label>
						<input type="hidden" name="id_topik" value="<?php echo $key->id_topik;?>">
					</div>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Hapus</button>
				</form>
			</div>
		</div>
	</div>
</div>
	<?php
} ?>

