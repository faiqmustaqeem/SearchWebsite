<?php
require_once 'functions.php';

$postType = -1;
$status = -1;

$inputID= '';
$inputUrl= '';
$inputName= '';

function createOrUpdate($id, $name, $url)
{
	global $Connection, $status;

	$idExists = Single_Value_Query("SELECT * from urls where id = '".mysqli_real_escape_string($Connection, $id)."'");

	if ($idExists)
	{
		if(mysqli_query($Connection, "UPDATE urls set 
			name = '".mysqli_real_escape_string($Connection, $name)."',
			url = '".mysqli_real_escape_string($Connection, $url)."'
			where id = '".mysqli_real_escape_string($Connection, $id)."'"))
		{
			$status = 2;
		}
		else
		{
			$status = 0;
		}
	}
	else
	{
		if(mysqli_query($Connection, "INSERT INTO urls set 
			id = '".mysqli_real_escape_string($Connection, $id)."',
			name = '".mysqli_real_escape_string($Connection, $name)."',
			url = '".mysqli_real_escape_string($Connection, $url)."'"))
		{
			$status = 1;
		}
		else
		{
			$status = 0;
		}

		if ($status == 0)
			$inputID = $id;

		if ($status == 0)
			$inputUrl = $url;

		if ($status == 0)
			$inputName = $name;
	}
}

if (isset($_POST['id']) && !empty($_POST['id']) &&
	isset($_POST['url']) && !empty($_POST['url'])&& 
	isset($_POST['name']) && !empty($_POST['name']))
{
	$postType = 0;
	
	createOrUpdate($_POST['id'], $_POST['name'], $_POST['url']);
}

if (!empty($_FILES))
{
	$postType = 1;

	require_once 'Classes/PHPExcel.php';

	$Reader = PHPExcel_IOFactory::createReaderForFile($_FILES['file']['tmp_name']);
	$Reader->setReadDataOnly(true);
	$objPHPExcel = $Reader->load($_FILES['file']['tmp_name']);
	$Sheet = $objPHPExcel->getSheet(0);

	for($i=2; ; $i++)
	{
		$fileID = $Sheet->getCell('A'.$i)->getValue();
		$fileName = $Sheet->getCell('B'.$i)->getValue();
		$fileUrl = $Sheet->getCell('C'.$i)->getValue();

		if ($fileID == '' || $fileName == '' || $fileUrl == '')
			break;

		createOrUpdate($fileID, $fileName, $fileUrl);
	}
}

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
		<h1>Add new record</h1>
		<?php 
		if ($postType == 0 && $status === 0)
			echo '<h3 class="text-danger">New record not added</h3>';
		else if ($postType == 0 && $status === 1)
			echo '<h3 class="text-success">Added new record successfully</h3>';
		else if ($postType == 0 && $status === 2)
			echo '<h3 class="text-success">Existing record updated successfully</h3>';
		?>
		<form method="POST" accept="add.php">
			<div class="inner-form">
				<div class="input-field second-wrap">
					<input id="id" name="id" type="text" placeholder="Enter id" value="<?php echo ($postType == 0 ? $inputID : '') ?>" required />
				</div>
				<div class="input-field second-wrap">
					<input id="name" name="name" type="text" placeholder="Enter name" value="<?php echo ($postType == 0 ? $inputName : '') ?>" required />
				</div>
				<div class="input-field second-wrap">
					<input id="url" name="url" type="text" placeholder="Enter url" value="<?php echo ($postType == 0 ? $inputUrl : '') ?>" required />
				</div>
				<div class="input-field third-wrap">
					<button class="btn-search" type="submit">
						<h3 style="color:white;">ADD</h3>
					</button>
				</div>
			</div>
		</form>

		<hr>

		<h1>Upload record file</h1>
		<?php
		if ($postType == 1 && $status === 0)
			echo '<h3 class="text-danger">Some records not added/updated</h3>';
		else if ($postType == 1 && ($status === 1 ||  $status === 2))
			echo '<h3 class="text-success">Added/Updated record successfully</h3>';
		?>
		<form method="POST" accept="add.php" enctype="multipart/form-data">
			<div class="inner-form">
				<div class="input-field second-wrap">
					<input type="file" name="file" id="file" accept=".xls,.xlsx"/>
				</div>
				<div class="input-field third-wrap">
					<button class="btn-search" type="submit">
						<h3 style="color:white;">IMPORT</h3>
					</button>
				</div>
			</div>
		</form>
	</div>

	<script src="js/extention/choices.js"></script>
</body>
</html>
