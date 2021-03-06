var currentFile='';
var initText = '';var prevText='';
var $previewContainer;
var $adminFileSelect;
var $adminFileEdit;
var $addButton,$removeButton,$saveButton;
var hasChanged=false;
var previewTimer;

$().ready(function() {
	$previewContainer = $('#previewContainer');
	$adminFileSelect = $('#adminFileSelect');
	$adminFileEdit = $('#adminFileEdit');
	$addButton = $('#addButton');
	$removeButton = $('#removeButton');
	$saveButton = $('#saveButton');
	$renameButton = $('#renameButton');
	
	$adminFileSelect.change(function() {
		if (!hasChanged)
		{
			loadFile(this.value);
		}
		else
		{
			var x = confirm("You changed something. Should the changes be saved?");
			if (x)
			{
				saveFile(
					function() {//callback when saved
						loadFile($adminFileSelect.val());
					});
			}
			else
			{
				loadFile(this.value);
			}
		}
	});
	
	$adminFileSelect.val($adminFileSelect.find("option:first").val()).change();
	$adminFileEdit.keyup(function() {
		if (this.value.toString() != initText)
		{
			$saveButton.removeAttr("disabled");
			hasChanged = true;
			if(this.value.toString() != prevText)
			{
				refreshPreview(this.value);
				prevText = this.value.toString();
			}
		}
		else if(this.value.toString() == initText.toString())
		{
			$saveButton.attr("disabled", "disabled");
		}
		
	});
	$adminFileEdit.keydown(function(e) {
		if (e.keyCode == 9)
		{
			var strPos = this.selectionStart;
			var part_one = this.value.substring(0,strPos);
			var part_two = this.value.substring(strPos,this.value.length);
			this.value = part_one + "    " + part_two;
			this.selectionStart = strPos + 4;
			this.selectionEnd = this.selectionStart;
			return false;
		}
	});
	$saveButton.click(function() {
		saveFile();
	});
	$addButton.click(function() {
		addFile();
	});
	$removeButton.click(function() {
		deleteFile();
	});
	$renameButton.click(function() {
		if (currentFile !== "")
		{
			renameFile(currentFile);
		}
		else
		{
			alert("no file selected");
		}
	});
	adjustWindow();
	$(window).resize(function() {
		adjustWindow();
	});
	
	if ($adminFileEdit.val())
	{
		refreshPreview($adminFileEdit.val());
	}
	$(window).bind('beforeunload',function() {
		if (hasChanged)
		{
			return "You have unsaved changes, if you leave the page without saving changes are lost!";
		}
	});
	$(window).keydown(function(e) {
		if (e.keyCode == 17)	//ctrl
		{
			holdStrg = true;
		}
		if (e.keyCode == 83)		// 'S'
		{
			if (holdStrg && hasChanged)
			{
				saveFile();
				return false;
			}
		}
	});
	$(window).keyup(function(e) {
		if (e.keyCode == 17)	//ctrl
		{
			holdStrg = false;
		}
		
	});
	$("table").colResizable({marginRight:"3px",marginLeft:"3px"});
});

var holdStrg = false;

function refreshFilelist()
{
	$.ajax({
		url:'ajax.php?action=filelist',
		success:function(data) {
			updateFilelist(data);
		}
	});
}
function updateFilelist(data)
{
	var options = $.parseJSON(data);
	$adminFileSelect.html('');
	$(options).each(function() {
		$adminFileSelect.append('<option value="'+ this.name + '" title="' + this.created + '">' + this.name + '</option>');
	});
}
function refreshPreview(text)
{
	clearTimeout(previewTimer);
	$previewContainer.addClass("loading");
	previewTimer = setTimeout(function() {
		$.ajax({
			url:"ajax.php?action=preview",
			type:'post',
			data:'text=' + encodeURIComponent(text),
			success:function(data) {
				$previewContainer.html(""+data).removeClass("loading");
			}
		});
	},300);
}

function loadFile(filename)
{
	if (filename != '')
	{
		$.ajax({
			url:'../admin/ajax.php',
			type:'post',
			data:'file=' + filename,
			success:function(data) {
				$adminFileEdit.val(data);
				currentFile = filename;
				refreshPreview(data);
				initText = data;
				prevText = data;
				hasChanged = false;
			}
		});
	}
	else
	{
		currentFile = '';
		initText = '';
		$adminFileEdit.val('');
		hasChanged = false;
		$previewContainer.html("");
	}
}
function addFile()
{
	var filename = prompt("Please enter a filename:");
	if (filename)
	{
		$.ajax({
			url:'ajax.php?action=add',
			type:'post',
			data:'file=' + filename,
			success:function(data) {
				updateFilelist(data);
			}
		});
	}
}
function saveFile(callback)
{
	var filename = "";var isNew = 0;
	if (currentFile != '')
	{
		filename = currentFile;
	}
	else
	{
		filename = prompt("Please enter a filename:");
		isNew = 1;
	}
	if (filename)
	{
		initText = $adminFileEdit.val();
		prevText = initText;
		var text = encodeURIComponent($adminFileEdit.val());
		$.ajax({
			url:'ajax.php?action=save',
			type:'post',
			data:'file=' + filename + "&isNew=" + parseInt(isNew) + "&text=" + text,
			success:function(data) {
				hasChanged = false;
				if ($.isFunction(callback)) callback();
				$saveButton.attr("disabled","disabled");
			}
		});
	}
}
function deleteFile()
{
	var filename = $adminFileSelect.val();
	if (filename)
	{
		var x = confirm('Do you really want to delete the file "' + filename + '"?');
		if (x)
		{
			$.ajax({
				url:'ajax.php?action=delete',
				type:'post',
				data:'file=' + filename,
				success:function(data) {
					updateFilelist(data);
				}
			});
		}
	}
}
function renameFile(oldFilename)
{
	var newFilename = prompt("Wählen Sie einen neuen Dateiname",oldFilename);
	if (newFilename && newFilename !== oldFilename)
	{
		$.ajax({
			url:'ajax.php?action=rename',
			type:'post',
			data:'oldFilename=' + encodeURI(oldFilename) + '&newFilename=' + encodeURI(newFilename),
			success:function(data) {
				updateFilelist(data);
				currentFile = newFilename;
				$adminFileSelect.val(currentFile);
			}
		});
	}
}
function adjustWindow()
{
	var height = $(window).height() - 140;
	$adminFileSelect.height(height+10);
	$adminFileEdit.height(height);
	$previewContainer.height(height);
}