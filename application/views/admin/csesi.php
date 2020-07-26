<div class="container">
<h3>Daftar Topik</h3>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">
					No
				</th>
				<th scope="col">
					Nama Sesi
				</th>
				<th scope="col">
					Opsi
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach ($topik as $key) {
			?>
			<tr>
				<td scope="row">
					<?php echo $i; $i++; ?>
				</td>
				<td>
					<a style="color: blue;" href="<?php echo site_url('Admin/sesi/'.$nama_sesi.'/'.$key->nama_topik) ;?>"><?php echo "$key->nama_topik"; ?></a>
				</td>
				<td>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit<?php echo $key->id_topik;?>">edit</button>
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus<?php echo $key->id_topik; ?>">hapus</button>
				</td>
			</tr>
						
			<?php
			}
			?>
		</tbody>
	</table>
</div>
