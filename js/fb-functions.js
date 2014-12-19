$(document).ready(function(){
    FB.init({
        appId  : '379258938775123',
        status : true,
        cookie : true,
        frictionlessRequests : true,
        xfbml:true
      });
})
      
	  
	  function postToFeed(link,share_image,job_title,description) {
		//alert (link);
						// calling the API ...
							var obj = {
							  method: 'feed',
							  link: link,
							  picture: share_image,
							  name: job_title,
							  caption: 'Visit the fan page today',
							  description: description
							};

							function callback(response) {
							  //document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
							}

						FB.ui(obj, callback);
						} 
	    					
		function sendMessage(link,share_image,job_title,description) {
					FB.ui({
							method: 'send',
							link: link,
							picture: share_image,
							name: job_title,
							description: description
							}
					, addcallback);
						function addcallback(response) {
						//document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
						}	
					}
	  
	  
	  
	  function sendInvite(page_id) {
	  alert(page_id);
					FB.ui({method: 'apprequests',
					  message: 'Hello my friend please have a look at Job Posting Application' ,
					  title: 'Send your friends an application request',
					  data: page_id
					}, requestCallback);
				  }


      function requestCallback(response) {
					if (response.request && response.to) {
								
							var request_ids = [];
							for(i=0; i<response.to.length; i++) {
								var temp = response.request + '_' + response.to[i];
								request_ids.push(temp);
							}
							var requests = request_ids.join(',');
							//alert('you have invited ' + i +' friends. Requested IDs are : ' + requests );
						} else {
							//alert('canceled');
						}
				  }