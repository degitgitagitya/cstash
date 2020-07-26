<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
xmp{ white-space:pre-wrap; word-wrap:break-word; }
pre{ white-space:pre-wrap; word-wrap:break-word; }
</style>
</head>
<body>
	<div style="padding-top: 8px; text-align: justify;">
		<h4><?php echo $judul;?></h4>
	<p><pre><p style="font-family:courier;"><xmp><?php echo $isi; ?></xmp></p></pre></p>
	<?php
	if (isset($tugas)) {
		if ($tugas!=null) {
		?>
		<h4>Tugas</h4> 
		<?php foreach ($tugas as $key) {
			?>
			<ol style="font-size: 13px;">
				<li><p><?php echo $key->isi_tugas;?></p>
					<p>file : <a href="<?php echo base_url("/tugas/$key->file");?>"><?php echo $key->file ?></a>
			     <a style=" color: red;" href="<?php echo site_url('Admin/detail_tugas/'.$key->id_tugas) ?>">detail</a>
						</p>		
				</li>
		
			</ol>
			<?php
			}
		}
	} ?>
	</div>
	
</body>
</Html>