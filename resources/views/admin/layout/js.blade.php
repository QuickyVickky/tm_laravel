
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script type="text/javascript">
    window.processingHTML_Datatable = '<span class="spinner-border spinner-border-reverse align-self-center loader-lg text-success"></span>';
</script>
<!-- jQuery -->
<script src="{{ asset('admin_assets/assets/js/jquery-3.5.1.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('admin_assets/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('admin_assets/assets/js/bootstrap.min.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ asset('admin_assets/assets/js/feather.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('admin_assets/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('admin_assets/assets/plugins/sweetalerts/sweetalert2.min.js')}}"></script>
<script src="{{ asset('admin_assets/assets/plugins/sweetalerts/custom-sweetalert.js')}}"></script>



<script src="{{ asset('admin_assets/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admin_assets/assets/js/select2.min.js')}}"></script>
<script src="{{ asset('admin_assets/assets/js/moment.min.js')}}"></script>

<!-- Custom JS -->
<script src="{{ asset('admin_assets/assets/js/script.js') }}"></script>
<script src="{{ asset('admin_assets/assets/js/bootstrap-datepicker.min.js')}}"></script> 

<script src="{{ asset('js/mycustomall.js')}}"></script>

<!-- END GLOBAL MANDATORY SCRIPTS -->

<!----Add here global Js ----start----->
<script type="text/javascript" >
const toast = swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					padding: '2em'
  			});
			
function showToastAlert(text1='Error', alerttype='error'){
		toast({
				type: alerttype,
				title: text1,
				padding: '2em',
	});
}
function showSweetAlert(text1='Completed',text2='Successfully Done', alerttype='1'){
		if(0==alerttype){  alerttype ="error";  } else if(1==alerttype) { alerttype ="success";  } else { alerttype ="question";  }
		swal(text1,text2,alerttype);
}

function isEmail(emailidgiven='') {
	 var regexemail = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(emailidgiven==''){  return true; }
	else
	{
  		return regexemail.test(emailidgiven);
	}
}

function randomIntFromInterval(min, max) { 
  return Math.floor(Math.random() * (max - min + 1) + min);
}
function makeid(length,ifnumberonly=0) {
   var result           = '';
   if(ifnumberonly==0){
   var characters  = 'abcdefghijklmVCXZQUIOP1234506789@$#!&-=:][{}KLnopqrstuvwxyzASDFGHJMNBWERTY';
   }
   else
   {
	    var characters = '123456789';
   }
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return  result;
}

function showAlertInToast(res){
		if(res.success==1){
			showToastAlert(res.msg, alerttype='success');
		}
		else
		{
			showToastAlert(res.msg, alerttype='error');
		}
}

function showAlert(res){
		if(res.success==1){
			showSweetAlert("Completed",res.msg, res.success); 
		}
		else
		{
			showSweetAlert("Wrong",res.msg, res.success); 
		}
}

		
</script>

<!----pusher notification starts here------->
@if(Session::get('adminrole')==constants('adminrole.A.key'))
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script type="text/javascript">
var PUSHER_APP_KEY = '{{ env("PUSHER_APP_KEY") }}';
  var PUSHER_APP_CLUSTER = '{{ env("PUSHER_APP_CLUSTER") }}';
  var PUSHER_APP_CHANNELNAME = '{{ env("PUSHERNOTIFICATIONVALUE").env("APP_NAME") }}';
  var PUSHER_APP_EVENTNAME = '{{ env("PUSHERNOTIFICATIONVALUE").env("APP_NAME") }}Event';
    // Enable pusher logging - don't include this in production
    //Pusher.logToConsole = true;
    var pusher = new Pusher( PUSHER_APP_KEY , {
      cluster: PUSHER_APP_CLUSTER
    });

var channel = pusher.subscribe(PUSHER_APP_CHANNELNAME);
    	channel.bind(PUSHER_APP_EVENTNAME, function(data) {
      	sendPushernotification(data);  //alert(JSON.stringify(data)); 
});
	
$(document).ready(function(){
Notification.requestPermission().then(function(permission) {
	if(permission === 'granted') {
		//sendPushernotification();
    }
});
});

function sendPushernotification(data){
		if(typeof refreshthistablecls == 'function') { refreshthistablecls();}
		const myNoti = new Notification(data.title, {
    	body: data.message,
    	icon: data.icon,
    	image: data.image.
		link = data.linkurl,
		});
		myNoti.onclick = function(event) {
  			event.preventDefault(); 
			if(data.linkurl!=''){ window.open(data.linkurl, '_blank'); }
		}
}


</script>
@endif
<!----pusher notification ends here------->
