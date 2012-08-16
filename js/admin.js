var currentFile='';
var initText = '';
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
						loadFile($adminFileSelect.val())
					});
			}
			else
			{
				loadFile(this.value);
			}
		}
	});
	$adminFileEdit.keyup(function() {
		if (this.value !== initText)
		{
			$saveButton.removeAttr("disabled");
			hasChanged = true;
		}
		else
		{
			$saveButton.attr("disabled", "disabled");
		}
		refreshPreview(this.value);
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
	adjustWindow();
	$(window).resize(function() {
		adjustWindow();
	});
	
	$(window).bind('beforeunload',function() {
		if (hasChanged)
		{
			return "You have unsaved changes, if you leave the page without saving changes are lost!";
		}
	});
	$("table").colResizable({marginRight:"3px",marginLeft:"3px"});
});
function refreshFilelist()
{
	$.ajax({
		url:'ajax.php?action=filelist',
		success:function(data) {
			var options = eval(data);
			$adminFileSelect.html('');
			$(options).each(function() {
				$adminFileSelect.append('<option value="'+ this + '">' + this + '</option>');
			});
		}
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
			data:'text=' + encodeURI(text),
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
				refreshFilelist();
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
		$.ajax({
			url:'ajax.php?action=save',
			type:'post',
			data:'file=' + filename + "&isNew=" + parseInt(isNew) + "&text=" + encodeURI($adminFileEdit.val()),
			success:function(data) {
				alert (data +'The file "' + filename + '" has been saved.');
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
					refreshFilelist();
				}
			});
		}
	}
}
function adjustWindow()
{
	var height = $(window).height() - 140;
	$adminFileSelect.height(height);
	$adminFileEdit.height(height);
	$previewContainer.height(height);
}