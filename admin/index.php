<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>pureMdBlog</title>
		<link rel="stylesheet" href="../css/admin.css" type="text/css"/>
	</head>
	<body>
		<header>
			<h1>Admin Panel</h1>
		</header>
<?php 
	include "../core/lib.php";
	error_reporting(E_ALL);
	$fileList = getFilelist("../content/","md");
?>
		<table>
			<thead>
				<tr>
					<th width="200">
						Select content file
					</th>
					<th width="50%">
						Edit file content
					</th>
					<th width="50%">
						Preview
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="adminFileSelect">
						<select size="10" id="adminFileSelect">
							<?php foreach ($fileList as $file) : ?>
							<option value="<?=$file["name"]?>" title="<?=$file["created"]?>"><?=$file["name"]?></option>
							<?php endforeach; ?>
						</select>
						<div class="center">
							
						</div>
					</td>
					<td class="adminFileEdit">
						<textarea id="adminFileEdit"></textarea>
						<div class="center">
							
						</div>
					</td>
					<td class="adminPreview">
						<div id="previewContainer">
							
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<button class="" id="addButton" title="Add content">+ Add</button>
		<button class="" id="removeButton" title="Remove file">&ndash; Delete</button>
		<button class="" id="renameButton" title="Rename file">Rename</button>
		<button id="saveButton" disabled>Save</button>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/admin.js"></script>
	</body>
</html>