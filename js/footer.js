$(document).ready(function(){
	var getUrl = window.location;
	var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
			/*sign up newsletter*/
		  $('.signUp_btn').on('click',function(){ 
				var email = $("input#signup_email").val();
					$('#errormessage').attr('style', 'color: rgb(255, 0, 0)');
				if($("input#signup_email").val()==""){
					$(".errorDiv").show().fadeOut(4000);
					$('#errormessage').text("Please enter email id");
					$("input#signup_email").focus();
					return false;
				}else if (!validateEmail(email))
					{
						$(".errorDiv").show().fadeOut(4000);
						$('#errormessage').text("Please enter valid email id");
						$("input#signup_email").focus();
						return false;
					}
				var signup_email 	= jQuery("#signup #signup_email").val();
				var form_data 		="signup_email="+signup_email;
				jQuery.ajax({
							type: "POST",
							data: form_data,
							url: baseUrl+'/newsletter_signup.php',
							success:function(response){
								$("#thankyou").attr('style', 'color: rgb(0,128,0)');
								document.getElementById('thankyou').innerHTML=response;
								$("#thankyou").show().fadeOut(5000);
								$("#signup_email").val('');
							}
					});
				return false;
			});
			/*search box*/
		  $('.search_txtBox').keypress(function(event) {
			  var keycode = event.which;
				if(keycode == '13') {
				var searchbox=$(".search_txtBox").val();
				if(searchbox==""){
					$(".error_log").html('Please enter search data');
					return false;
				}else{
					$("#searchdata").submit();
				}
			}
		 });
	  });
	var sysmsg = "<?=$sysmsg?>";
	if(sysmsg==0){
		$(".errorDiv").hide();
	}
	else{
		$(".errorDiv").show().fadeOut(4000);
	}
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
		}
 /*enquiry onload*/
	$(window).load(function(){
			  $("#enquirysection").hide();
			  $("#stateInput").hide();
			  $("#cityInput").hide();
			  $("#state").hide();
			  $("#city").hide();
			  $("#message_section").hide();
		});
		/*validate email address*/
		function validateEmailAddress(elementValue){
			var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
			var op = emailPattern.test(elementValue); 
			if(op==false){
				return false;
			}else{
			   return true;
			}
	    }
		/*validate name*/
		function validateFirstnameLastname(obj, msg){
			var validStr = /^[a-zA-Z ]{1,}$/;
			NameArr=obj.value.split("");
			/*if(NameArr.length>2)
			{
				alert(msg+'111');
				obj.focus();
				obj.select();
				return false;
			}*/
			for(i=0;i<NameArr.length+5;i++)
			{
				if (validStr.test(NameArr[i]) == false)
				{
					jQuery(".errMsg").text(msg);
					obj.focus();
					obj.select();
					return false;
				}
			}
			return true;
		}
		/*validate numbers only*/
		function validateNumbersOnly(e){
			var unicode = e.charCode ? e.charCode : e.keyCode;
			if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)||(unicode == 43)){
				return true;
			}else{
				//alert("This field accepts only Numbers");
				return false;
			}
		}