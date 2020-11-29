$(document).ajaxStart(function () {
                $('.loading').show();
            })
            .ajaxStop(function () {
                $('.loading').hide();
            });


//table management 
var recordsTotal;
$(document).ready(function() {

	applyTable (false);

});

function applyTable (isReload){

	if (isReload) {
			$('#list').DataTable().destroy();
	}


	 $('#list').dataTable({
		"bProcessing": true,
	 	"serverSide": true,
	 	"ajax":{
	        url :"table_handler.php?action=getData",
	        type: "GET",
	        error: function(){
	          $("#post_list_processing").css("display","none");
	        }
	  	},
	  	"fnDrawCallback": function() {
	        var api = this.api()
	        var json = api.ajax.json();
	        console.log(json.sum);
	        $(api.column(5).footer()).html("Total sum = "+json.sum);
	    }
	});

}


//upload file 

function uploadFile() {
	var formData = new FormData();
	formData.append('file', $('#json_file')[0].files[0]);
	formData.append('action', 'import');

	$.ajax({
	       url : 'file_handler.php',
	       type : 'POST',
	       data : formData,
	       processData: false,  // tell jQuery not to process the data
	       contentType: false,  // tell jQuery not to set contentType
	       success : function(data) {
	       	//reset and hide form 
	       	$('#addFile').modal('hide');
	       	$('#json_file').val('');

	        var	res = JSON.parse(data);
       		if (res.status === true) {
       			applyTable (true);
	       		 $.toast({
	                type: 'success',
	                title: 'Success',
	                subtitle: '',
	                content:  res.message,
	                delay: 3000
	            });
	       	}
	       	else
		       	{
	       		 $.toast({
		                type: 'warning',
		                title: 'Error',
		                subtitle: '',
		                content: res.message ,
		                delay: 3000
		            });
		         
		       }
	       	}
	});
}

 //end upload file

