<!DOCTYPE html>
<html>
<head>
	<title>Upload Image TinyMCE</title>
</head>
<body>
	<textarea id="article"></textarea>

	<script src="assets/js/tinymce/tinymce.min.js"></script>
	<script>
	tinymce.init({
	    selector: '#article',
	    plugins: 'image code',
	    toolbar: 'undo redo | image code',
	    
	    // without images_upload_url set, Upload tab won't show up
	    images_upload_url: 'upload.php',
	    
	    // override default upload handler to simulate successful upload
	    images_upload_handler: function (blobInfo, success, failure) {
	        var xhr, formData;
	      
	        xhr = new XMLHttpRequest();
	        xhr.withCredentials = false;
	        xhr.open('POST', 'upload.php');
	      
	        xhr.onload = function() {
	            var json;
	        
	            if (xhr.status != 200) {
	                failure('HTTP Error: ' + xhr.status);
	                return;
	            }
	        
	            json = JSON.parse(xhr.responseText);
	        
	            if (!json || typeof json.location != 'string') {
	                failure('Invalid JSON: ' + xhr.responseText);
	                return;
	            }
	        
	            success(json.location);
	        };
	      
	        formData = new FormData();
	        formData.append('file', blobInfo.blob(), blobInfo.filename());
	      
	        xhr.send(formData);
	    },
	});
	</script>

</body>
</html>