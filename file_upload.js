var handleUpload = function(event){
	//event.preventDefault();
	//event.stopPropagation();
	
	var fileInput = document.getElementById('file');
	
	
	var data = new FormData();
	
	data.append('ajax' , true);
	
	for( var i =0; i<fileInput.files.length; ++i){
		data.append('file[]', fileInput.files[i]);	
	}
	var request = new XMLHttpRequest();
	
	request.upload.addEventListener('progress', function(event){
		if(event.lengthComputable){
			var percent = event.loaded / event.total;
			var progress = document.getElementById('upload_progress');
				
			while(progress.hasChildNodes()){
				progress.removeChild(progress.firstChild);
			}
			
			progress.appendChild(document.createTextNode(Math.round(percent *100) + ' %'));
		}
	});
	
	request.upload.addEventListener('load', function(event){
		document.getElementById('upload_progress').style.display = 'none';
	});
	
	request.upload.addEventListener('error', function(event){
		alert('Upload failed');
	});
	
	/* request.addEventListener('readystatechange', function(event){
		console.log(this);
		if(this.readyState == 4){
			console.log(this.status);
			if(this.status == 200){
				var links = document.getElementById('uploaded');
				var uploaded = eval(this.response);
				console.log("hello");
				console.log(this);
				console.log(uploaded);
				console.log("world");
				var div, a;
				for (var i =0; i < uploaded.length; ++i){
					div = document.createElement('div');
					a = document.createElement('a');
					
					a.setAttribute('href', 'files/' + uploaded[i]);
					a.appendChild(document.createTextNode(uploaded[i]));
					
					div.appendChild(a);
					links.appendChild(div);
				}
			}else{
				console.log('Server replied wiht HTTP status ' + this.status);
			}
		}
	});*/
	
	request.open('POST', 'add_new_schedule_page.php');
	request.setRequestHeader('Cache-Conrol', 'no-cache');
	
	document.getElementById('upload_progress').style.display = 'block';
	//request.send(data);
	//console.log(request.response);
}

window.addEventListener('load', function(event){
	var submit = document.getElementById('submit');
	submit.addEventListener('click', handleUpload);
});