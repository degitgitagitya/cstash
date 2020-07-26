<h3>Daftar Tugas</h3>
<?php
foreach ($sesi as $key) {
	?>
	<div class="container">
		<h5><?php echo "$key->nama_sesi"; ?></h5>
		<ul style="list-style-type:none;">
			<?php foreach ($key->topik as $val) {
				?>
				<li><p><?php echo "$val->nama_topik"; ?></p></li>
				<ol>
				<?php $i=0; foreach ($val->konten as $lue) {
					$i++;
					if ($lue->tugas!=null) {
						?>
						<li>
							<a href="<?php echo site_url("Admin/Sesi/").$key->nama_sesi.'/'.$val->nama_topik.'/'.$i; ?>"><?php echo $lue->tugas["file"];?></a>
			     			<a style="color: red;" href="<?php echo site_url('Admin/detail_tugas/'.$lue->tugas["id_tugas"]) ?>">detail</a>
						</li>
						<?php
					}
				} ?>
				</ol>
				<?php
			} ?>
		</ul>
	</div>
	<?php
}
?>