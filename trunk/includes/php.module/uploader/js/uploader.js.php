<script type="text/javascript">
$(document).ready(function() {
	$("#fileUploadgrow3").fileUpload({
		'uploader': '<?php echo deSanitizeData($absoluteURL).GetSetting('uploader_swf', $feature_id)?>',
		'cancelImg': '<?php echo deSanitizeData($absoluteURL).GetSetting('cancel_image', $feature_id)?>',
		'script': '<?php echo GetSetting('upload_script', $feature_id)?>',
		'buttonImg' : '<?php echo deSanitizeData($absoluteURL).GetSetting('upload_button', $feature_id)?>',
		'wmode' : 'transparent',
		'auto'	: true,
		'height' : 25,
		'width' : 114,
		'multi': <?php echo deSanitizeData(GetSetting('multi_upload', $feature_id))?>,
		'fileDesc': '<?php echo GetSetting('file_extensions_description', $feature_id)?>',
		'fileExt': '<?php echo GetSetting('file_extensions', $feature_id)?>',
		'scriptData': {'nav_tab_id': <?php echo SanitizeData($nav_tab_id)?>,'feature_id': <?php echo SanitizeData($feature_id)?>,'vignette_id': <?php echo SanitizeData($vignette_id)?>}, 

		onError: function (event, queueID ,fileObj, errorObj) {
			var msg;
			if (errorObj.status == 404) {
				alert('Could not find upload script. Use a path relative to: '+'<?= getcwd() ?>');
				msg = 'Could not find upload script.';
			} else if (errorObj.type === "HTTP")
				msg = errorObj.type+": "+errorObj.status;
			else if (errorObj.type ==="File Size")
				msg = fileObj.name+'<br>'+errorObj.type+' Limit: '+Math.round(errorObj.sizeLimit/1024)+'KB';
			else
				msg = errorObj.type+": "+errorObj.text;
			$.jGrowl('<p></p>'+msg, {
				theme: 	'error',
				header: 'ERROR',
				sticky: true
			});			
			$("#fileUploadgrowl" + queueID).fadeOut(250, function() { $("#fileUploadgrowl" + queueID).remove()});
			return false;
		},
		onCancel: function (a, b, c, d) {
			var msg = "Cancelled uploading: "+c.name;
			$.jGrowl('<p></p>'+msg, {
				theme: 	'warning',
				header: 'Cancelled Upload',
				life:	4000,
				sticky: false
			});
		},
		onClearQueue: function (a, b) {
			var msg = "Cleared "+b.fileCount+" files from queue";
			$.jGrowl('<p></p>'+msg, {
				theme: 	'warning',
				header: 'Cleared Queue',
				life:	4000,
				sticky: false
			});
		},
		onComplete: function (a, b ,c, d, e) {
			var size = Math.round(c.size/1024);
			$.jGrowl('<p></p>'+c.name+' - '+size+'KB', {
				theme: 	'success',
				header: 'Upload Complete',
				life:	4000,
				sticky: false
			});
		picture_list.location.reload();
		}
	});
});

</script>
