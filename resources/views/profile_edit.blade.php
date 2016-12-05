@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Profile</div>
                <div class="panel-body">
                    {{ Form::model($user, array('route' => array('profile', $user->id), 'method' => 'PUT'), ['class'=>"form-horizontal"]) }}            
                        <div class="form-group">
                            <label for="login" class="col-md-4 control-label">Логин</label>

                            <div class="col-md-6">
                                <input id="login" type="text" class="form-control" name="login" value="{{$user->login}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="full_name" class="col-md-4 control-label">Полное имя</label>

                            <div class="col-md-6">
                                <input id="full_name" type="text" class="form-control" name="full_name" value="{{$user->full_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birthday" class="col-md-4 control-label">Дата рождения</label>

                            <div class="col-md-6">
                                <input id="birthday" type="date" class="form-control" name="birthday" value="{{$user->birthday}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Адрес</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{$user->address}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-md-4 control-label">Город</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" value="{{$user->city}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state" class="col-md-4 control-label">Регион</label>

                            <div class="col-md-6">
                                <input id="state" type="text" class="form-control" name="state" value="{{$user->state}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="country" class="col-md-4 control-label">Страна</label>

                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control" name="country" value="{{$user->country}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pzip" class="col-md-4 control-label">Индекс</label>

                            <div class="col-md-6">
                                <input id="pzip" type="text" class="form-control" name="pzip" value="{{$user->zip}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Пароль</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Подтверждение пароля</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                                               <div class="form-group">

                           <label class="col-md-4 control-label"></label>
                            <div class="col-md-6" id="mapbtns">
                                 <button type="button" class="btn btn-warning" id="meh">
                                    Показать карту
                                </button>

                            </div>
                        </div>
                        <div class="form-group">
                           <label class="col-md-4 control-label"></label>

                        <div id="upmapmesspool" class="col-md-6" style="color: red; font-weight: bold;"></div>
                        </div>
                        <div class="form-group" id="mapdiv" style="display: none;">
                           <label class="col-md-4 control-label">Карта</label>
                            <div  class="col-md-6">
                                <div id="map_canvas" style="width:343px; height:200px"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
 <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD0ffMzdlaD3w-h4I8ge3Kn6PYO4RF83ro&sensor=false"></script>
    <script type="text/javascript">

$("document").ready(function() {
    $('#meh').click(function(){
    if($('#mapdiv').css('display') == "none") { $('#mapdiv').css('display', 'block'); $('#meh').text("Cкрыть карту"); ShowPositon(); $('#mapbtns').append('<button type="button" class="btn btn-success" onclick="uploadMap()" id="uploadmapbtn">Обновить карту</button>');}
    else { $('#mapdiv').css('display', 'none'); $('#meh').text("Показать карту"); $('#uploadmapbtn').remove();}
    });
});

function uploadMap(){
    console.log('update');
    var country = $('#country').val();
    var address = $('#address').val();
    var city = $('#city').val();
    var state = $('#state').val();
    var zip = $('#pzip').val();


    ShowPositon(city, address, country, state, zip);
}

        function ShowPositon(city="", address="", country="", state="", zip=""){
          //alert('azaza');
          
          console.log('city ='+city);
          var zoom = 9;
          var x = 59.940224;
          var y = 30.308533;
          var geocoder = new google.maps.Geocoder();
          
          var targetaddress = "";
          if(country != "") targetaddress += ", "+country;
          if(state != "") targetaddress += ", "+state;
          if(city != "") targetaddress += ", "+city;
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
            var myLatLng = new google.maps.LatLng( x, y );
            var marker = new google.maps.Marker( {position: myLatLng, map: map});
            marker.setPosition( myLatLng );
            $('#upmapmesspool').text("");
            }
          else {
            $('#upmapmesspool').text("Ошибка получения координат!"); 
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

@endsection
