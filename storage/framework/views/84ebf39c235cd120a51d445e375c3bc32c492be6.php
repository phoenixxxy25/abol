<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                <div class="pull-right">
                <?php if(!Auth::guest()): ?>
                <?php if(Auth::user()->id == $user[0]->id): ?>
                  <a class="btn pull-right btn-warning" style="margin-right: 3px;"  href="<?php echo e(action('HomeController@editprofileform',['id'=>$user[0]->id])); ?>">Редактировать</a> 
                <?php endif; ?>
                <?php endif; ?>
                </div>
          <h1><?php echo e($user[0]->full_name); ?></h1>   
          <body onload="ShowPositon('<?php echo e($user[0]->city); ?>', '<?php echo e($user[0]->address); ?>', '<?php echo e($user[0]->country); ?>',  '<?php echo e($user[0]->state); ?>', '<?php echo e($user[0]->zip); ?>')">
            <div id="map_canvas" style="width:300px; height:300px"></div>
          </body>
          <table>
              <tr>
                <td>Name:</td>
                <td> <?php echo e($user[0]->full_name); ?> (<?php echo e($user[0]->login); ?>)</td>
              </tr>

              <tr>
                <td>Mail:</td>
                <td><?php echo e($user[0]->email); ?></td>
              </tr>
              <tr>
                <td>BirthDay:</td>
                <td><?php echo e(substr($user[0]->birthday,  0, -9)); ?></td>
              </tr>
            </table>
          <table>
            <tr>
              <td>Country:</td>
              <td><?php echo e($user[0]->country); ?></td>
            </tr>
            <tr>
              <td>State:</td>
              <td><?php echo e($user[0]->state); ?></td>
            </tr>
            <tr>
              <td>City</td>
              <td><?php echo e($user[0]->city); ?></td>
            </tr>
            <tr>
              <td>Address:</td>
              <td><?php echo e($user[0]->address); ?></td>
            </tr>
            <tr>
              <td>Zip:</td>
              <td><?php echo e($user[0]->zip); ?></td>
            </tr>
          </table>


<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD0ffMzdlaD3w-h4I8ge3Kn6PYO4RF83ro&sensor=false"></script>
    <script type="text/javascript">
        function ShowPositon(city="", address="", country="", state="", zip=""){

          console.log('city ='+city);
          var zoom = 9;
          var x = 59.940224;
          var y = 30.308533;
          var geocoder = new google.maps.Geocoder();
          
          var targetaddress = "";
          if(country != "") targetaddress += ", "+country;
          if(state != "") targetaddress += ", "+state;
          if(city != "") { targetaddress += ", "+city; zoom=12;}
          if(address != "") { targetaddress += ", "+address;  zoom = 15;}
          if(zip != "") targetaddress += ", "+zip;
          if(targetaddress == "") targetaddress = "киев";

          console.log(targetaddress);

          geocoder.geocode( { 'address': targetaddress}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            x = results[0].geometry.location.lat();
            y = results[0].geometry.location.lng();
          
            var mapOptions = {
                center: new google.maps.LatLng(x, y),
                zoom: zoom,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            
            var map = new google.maps.Map(document.getElementById("map_canvas"),
              mapOptions);
            var myLatLng = new google.maps.LatLng(x, y);
            var marker = new google.maps.Marker( {position: myLatLng, map: map});
            marker.setPosition( myLatLng );
            }
          else {
            console.log('error');
            geocoder.geocode( { 'address': "Киев"}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              x = results[0].geometry.location.lat();
              y = results[0].geometry.location.lng();
            
              var mapOptions = {
                  center: new google.maps.LatLng(50.4501,30.5234),
                  zoom: zoom,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
              };
              
              var map = new google.maps.Map(document.getElementById("map_canvas"),
                mapOptions);
              var myLatLng = new google.maps.LatLng(50.2901,30.5234 );
              var marker = new google.maps.Marker( {position: myLatLng, map: map});
              marker.setPosition( myLatLng );

              var contentString = '<div style="font-weight: bold; font-size: 20px; padding: 10px">Локация не определена!</div>';
              var infowindow = new google.maps.InfoWindow({
                content: contentString
              });
              infowindow.open(map,marker);
              }
             
          });
          } 
          });
          //var map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
          return (false);
        }



        function extmap(){
            var wdth = $('#map_canvas').css('width');
            var hght = $('#map_canvas').css('height');
            wdth = wdth.substring(0, wdth.length - 2);
            hght = hght.substring(0, hght.length - 2);
            wdth = wdth-0; hght = hght-0; wdth = wdth+50; hght = hght+50;
            hght = hght+"px"; wdth = wdth+"px";
            //alert(hght + " and " + wdth);

            $('#map_canvas').css('width', wdth);
            $('#map_canvas').css('height', hght);
        }
        function redcmap(){
            var wdth = $('#map_canvas').css('width');
            var hght = $('#map_canvas').css('height');
            wdth = wdth.substring(0, wdth.length - 2);
            hght = hght.substring(0, hght.length - 2);
            wdth = wdth-50; hght = hght-50;
            hght = hght+"px"; wdth = wdth+"px";

            //alert();
            $('#map_canvas').css('width', wdth);
            $('#map_canvas').css('height', hght);
        }
    </script>
  

</head>

	<meta name="_token" content="<?php echo e(csrf_token()); ?>"/>
                </div>
	            </div>
	        </div>
	    </div>  
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>