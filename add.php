<?php
require_once 'functions.php';

$status = -1;

if (isset($_POST['id']) && !empty($_POST['id']) &&
	isset($_POST['url']) && !empty($_POST['url']))
{
	if(mysqli_query($Connection, "INSERT INTO urls set 
		id = '".$_POST['id']."',
		url = '".mysqli_real_escape_string($Connection, $_POST['url'])."'"))
	{
		$status = 1;
	}
	else
	{
		$status = 0;
	}
}

$maxID = Single_Value_Query("SELECT max(id) + 1 from urls");

$id = $maxID;
if ($status == 0)
	$id = $_POST['id'];

$url= '';
if ($status == 0)
	$url = $_POST['url'];

?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="author" content="colorlib.com">
	<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
	<link href="css/main.css" rel="stylesheet" />
</head>
<body>
	<div class="s003">
		<?php 
		if ($status === 0)
			echo '<h1>Not added</h1><br>';
		else if ($status === 1)
			echo '<h1>Added</h1><br>';
		?>
		<form method="POST" accept="add.php">
			<div class="inner-form">
				<div class="input-field second-wrap">
					<input id="id" name="id" type="text" placeholder="Enter id" value="<?php echo $id ?>" required />
				</div>
				<div class="input-field second-wrap">
					<input id="url" name="url" type="text" placeholder="Enter url" value="<?php echo $url ?>" required />
				</div>
				<div class="input-field third-wrap">
					<button class="btn-search" type="submit">
						<svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
							<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
						</svg>
					</button>
				</div>
			</div>
		</div>
	</form>
	<script src="js/extention/choices.js"></script>
</body>
</html>
