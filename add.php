<?php
require_once 'functions.php';

$status = -1;

if (isset($_POST['id']) && !empty($_POST['id']) &&
	isset($_POST['url']) && !empty($_POST['url'])&& 
	isset($_POST['name']) && !empty($_POST['name']))
{
	echo "INSERT INTO urls set 
	id = '".mysqli_real_escape_string($Connection, $_POST['id'])."',
	name = '".mysqli_real_escape_string($Connection, $_POST['name'])."',
	url = '".mysqli_real_escape_string($Connection, $_POST['url'])."'";
	if(mysqli_query($Connection, "INSERT INTO urls set 
		id = '".mysqli_real_escape_string($Connection, $_POST['id'])."',
		name = '".mysqli_real_escape_string($Connection, $_POST['name'])."',
		url = '".mysqli_real_escape_string($Connection, $_POST['url'])."'"))
	{
		$status = 1;
	}
	else
	{
		$status = 0;
	}
}

// $maxID = Single_Value_Query("SELECT max(id) + 1 from urls");

// $id = $maxID;
$id = '';

if ($status == 0)
	$id = $_POST['id'];

$url= '';
if ($status == 0)
	$url = $_POST['url'];

$name= '';
if ($status == 0)
	$name = $_POST['name'];

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
					<input id="name" name="name" type="text" placeholder="Enter name" value="<?php echo $name ?>" required />
				</div>
				<div class="input-field second-wrap">
					<input id="url" name="url" type="text" placeholder="Enter url" value="<?php echo $url ?>" required />
				</div>
				<div class="input-field third-wrap">
					<button class="btn-search" type="submit">
					<!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d=/></svg> -->
					<!-- <img src="add.png" alt="ADD" height="42" width="42"> -->
					<h3 style="color:white;">ADD</h3>
					</button>
				</div>
			</div>
		</div>
	</form>

	<form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>
        
            </div>
        
        </form>
	<script src="js/extention/choices.js"></script>
</body>
</html>
