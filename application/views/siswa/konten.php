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
	<div style="padding-top: 10px; text-align: justify;" class="container">
		<h4><?php echo $judul;?></h4>
	<p><pre><p style="font-family:courier;"><xmp><?php echo $isi; ?></xmp></p></pre></p>
	<?php
	if (isset($tugas)) {
		if ($tugas!=null) {
		?>
		<h5>Tugas</h5> 
		<?php foreach ($tugas as $key) {
			?>
			<ol style="font-size: 13px;" >
				<li><p><?php echo $key->isi_tugas;?></p>
					<p>file : <a href="<?php echo base_url("/tugas/$key->file");?>"><?php echo $key->file ?></a></p>
					<button style="margin: 0px; font-size: 14px; height: 30px; width: 55px; padding-left: 5px; padding-top: 2px;" type="button" class="btn btn-success" data-toggle="modal" data-target="#subTugas<?php echo $key->id_tugas; ?>">Submit</button>
				</li>
		
			</ol>
			<?php
			}
		}
	} ?>
	</div>
	
</body>
</html>