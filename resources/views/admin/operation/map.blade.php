<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bloo | Ajouter des sites</title>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/map/jquery-ui.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/map/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div id="map"></div>
<div class="pac-card" id="pac-card">
    <div id="pac-container">
            <a class="pac-return" href="{{route('operation.second',[$operation->id])}}"></a>
        <input id="pac-input" class="controls pac-search" type="text" placeholder="Entrer une localisation">
    </div>
    <div id="info-container">
        <form class="pac-form" method="post" action={{route('site.store')}}>
            @csrf
            <input id="nom" name="nom" class="controls" type="text" placeholder="nom du site" required>
            <input id="rayon" name="rayon" class="controls" min="0" type="number" placeholder="Rayon(en m)" required>
            <input id="pays" name="pays" class="controls" type="text" placeholder="Pays" required>
            <input id="ville" name="ville" class="controls" type="text" placeholder="Ville" required>
            <input id="lat" name="lat" class="controls" type="hidden">
            <input id="long" name="lng" class="controls" type="hidden">
            <input type="hidden" name="operation_id" value="{{$operation->id}}">
            <input class="controls-btn" type="submit" value="@lang("Enregistrer")" >
        </form>
    </div>
    <div class="pac-table">

        <!-- Table start -->
        <table class="tablemanager table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ trans('Site') }}</th>
                <th>{{ ('Rayon') }}</th>
                <th>{{ trans('Pays') }}</th>
                <th>{{ trans('Ville') }}</th>
                <th class="disableFilterBy">{{ trans('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sites as $site)
                <tr>
                    <td>{{$site->id}}</td>
                    <td>{{$site->name}}</td>
                    <td>{{$site->rayon}}</td>
                    <td>@isset($site->country){{$site->country->name_fr}}@endisset</td>
                    <td>@isset($site->city){{$site->city->name}} @endisset</td>
                    <td><a href="{{route('site.destroy',[$site->id])}}" class="del-site">Supprimer</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pac-pick pac-pick-active"></div>
    </div>
</div>
<div id="infowindow-content" class="infowindow-content">
    <img src="" width="16" height="16" id="place-icon" class="place-icon">
    <span id="place-name" class="place-name title"></span><br>
    <span id="place-address" class="place-address"></span>
</div>

<!-- Replace the value of the key parameter with your own API key. -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4bZln12ut506FLipFx-kXh95M-zZdUfc&libraries=places&callback=initMap" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('assets/map/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/map/tableManager.js')}}"></script>
<script>
    //réinitialisationn du formulaire
    resetForm();
    // Chargement des sites
    let sites;
    let getUrl = window.location;
    let base_url = getUrl.protocol + "//" + getUrl.host ;
    // get last uri segment
    let pageUrl = window.location.href;
    let lastUrlSegment = pageUrl.substr(pageUrl.lastIndexOf('/') + 1);

    $.ajax({
        // url : base_url + "/sites", //A remplacer par la bonne route
        url : base_url + "/operation_sites_json/{{$operation->id}}", //A remplacer par la bonne route
        dataType: 'JSON',
        success: function(data)
        {
            sites = data;
            // console.log(sites);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Erreur de chargement des sites');
            // console.log("Erreur: impossible de charger les sites ", textStatus);
        }
    });


    let markers = [];

    // chargement de la carte google
    function initMap() {
        let map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 4.050000, lng: 9.700000 },
            zoom: 8,
            mapTypeControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
        });

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                }
            );
        }
        //positionnement de la zone de recherche
        let card = document.getElementById('pac-card');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

        // set input autocomplete
        let input = document.getElementById('pac-input');
        let autocomplete = new google.maps.places.Autocomplete(input);

        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

        let infowindow = new google.maps.InfoWindow();
        let infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        let marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            let place = autocomplete.getPlace();

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                // map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            let address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || ''),
                    // (place.address_components[3] && place.address_components[3].short_name || '')
                ].join(' ');
            }

            //remplissage du formulaire
            for(let i = 0; i < place.address_components.length; i += 1) {
                let addressObj = place.address_components[i];
                for(let j = 0; j < addressObj.types.length; j += 1) {
                    if (addressObj.types[j] === 'country') {
                        document.getElementById('pays').value = addressObj.long_name; // Pays
                    }else if (addressObj.types[j] === 'locality') {
                        document.getElementById('ville').value = addressObj.long_name; // Ville
                    }
                }
            }
            document.getElementById('lat').value = place.geometry.location.lat(); // latitude
            document.getElementById('long').value = place.geometry.location.lng(); // longitude

            infowindowContent.children['place-icon'].src = place.icon;
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = address;
            infowindow.open(map, marker);
        });

        // Configure the click listener.
        map.addListener('click', function(mapsMouseEvent) {
            //réinitialisationn du formulaire
            resetForm();

            // Close the current InfoWindow.
            infowindow.close();
            marker.setVisible(false);

            let position = mapsMouseEvent.latLng;
            marker.setPosition(position);
            marker.setVisible(true);

            document.getElementById('lat').value = position.lat(); // latitude
            document.getElementById('long').value = position.lng(); // longitude

            const request = {
                location: position,
                radius: '1000'
            };


            const service = new google.maps.places.PlacesService(map);

            service.nearbySearch(request, (results, status) => {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    const request2 = {
                        placeId: results[0].place_id,
                        fields: ["name", "icon", "geometry", "address_components"]
                    };

                    service.getDetails(request2, (place, etat) => {
                        if (etat === google.maps.places.PlacesServiceStatus.OK) {
                            let address = '';
                            if (place.address_components) {
                                address = [
                                    (place.address_components[0] && place.address_components[0].short_name || ''),
                                    (place.address_components[1] && place.address_components[1].short_name || ''),
                                    (place.address_components[2] && place.address_components[2].short_name || ''),
                                    //(place.address_components[3] && place.address_components[3].short_name || '')
                                ].join(' ');
                            }

                            infowindowContent.children['place-icon'].src = place.icon;
                            infowindowContent.children['place-name'].textContent = place.name;
                            infowindowContent.children['place-address'].textContent = address;
                            infowindow.open(map, marker);

                            //remplissage du formulaire
                            for(var i = 0; i < place.address_components.length; i += 1) {
                                var addressObj = place.address_components[i];
                                for(var j = 0; j < addressObj.types.length; j += 1) {
                                    if (addressObj.types[j] === 'country') {
                                        document.getElementById('pays').value = addressObj.long_name; // Pays
                                    }else if (addressObj.types[j] === 'locality') {
                                        document.getElementById('ville').value = addressObj.long_name; // Ville
                                    }
                                }
                            }
                        }
                    });
                }
            });
        });

        //add markers
        window.setTimeout(() => {
            let search = document.getElementById("pac-card");
            unfade(search);
            google.maps.event.addDomListener(window, 'load', addMarkers(map));
        }, 3000);


    }

    function addMarkers(map) {
        clearMarkers();

        for (let i = 0; i < sites.length; i++) {
            addMarkerWithTimeout(sites[i], i * 200, map);
        }
    }

    function addMarkerWithTimeout(site, timeout, map) {
        let position = { lat: parseFloat(site.lat), lng: parseFloat(site.lng) };
        window.setTimeout(() => {
            let marker = new google.maps.Marker({
                position: position,
                map,
                animation: google.maps.Animation.DROP
            });
            let contentString = "" +
                "<div class=\"infowindow-content\">\n" +
                "    <span class=\"place-name title\">"+ site.nom + "</span><br>" +
                "    <span class=\"place-address\">"+ site.ville +" "+ site.pays +"</span>\n" +
                "</div>";

            let infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            marker.addListener("click", () => {
                infowindow.open(map, marker);
            });
        }, timeout);
    }


    function clearMarkers() {
        for (let i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    }

    function unfade(element) {
        var op = 0.1;  // initial opacity
        element.style.display = 'block';
        var timer = setInterval(function () {
            if (op >= 1){
                clearInterval(timer);
            }
            element.style.opacity = op;
            element.style.filter = 'alpha(opacity=' + op * 100 + ")";
            op += op * 0.1;
        }, 10);
    }

    // jquery table
    $('.tablemanager').tablemanager({
        // firstSort: [[3,0],[2,0],[1,'asc']],
        disable: ["last"],
        appendFilterby: true,
        dateFormat: [[4,"mm-dd-yyyy"]],
        debug: true,
        vocabulary: {
            voc_filter_by: 'Filter By',
            voc_type_here_filter: 'Filter...',
            voc_show_rows: 'Rows Per Page'
        },
        pagination: true,
        showrows: [5,10,20,50,100],
        disableFilterBy: [1]
    });

    // Affichage (toggle) du tableau
    $('.pac-pick').click(function () {
        if(!$(this).hasClass('pac-pick-active')){
            $(this).parent().removeClass('pac-table-visible');
            $(this).addClass('pac-pick-active');
        }else{
            $(this).parent().addClass('pac-table-visible');
            $(this).removeClass('pac-pick-active');
        }
    });

    // envoie du formulaire
    $('.pac-form').on('submit', function(e){
        e.preventDefault();
        $('.controls-btn').prop( "disabled", true );
        $.ajax({
            url : $(this).attr('action'), //A remplacer par la bonne route
            type: "POST",
            dataType: 'JSON',
            data: $(this).serialize(),
            success: function(data)
            {
                // console.log(data);
                if(data.Erreur){
                    alert(data.Erreur);
                }else{
                    let last_site = data;
                    let url = base_url + "/sites/" + last_site.id;

                    // Ajouter à la fin du tableau
                    let ligne = "<tr>"+
                        "<td>"+ last_site.id +"</td>"+
                        "<td>"+ last_site.nom +"</td>"+
                        "<td>"+ last_site.rayon +"</td>"+
                        "<td>"+ last_site.pays +"</td>"+
                        "<td>"+ last_site.ville +"</td>"+
                        "<td><a href='"+ url +"' class='del-site'>Supprimer</a></td>"+
                        "</tr>";

                    $('.tablemanager tbody').prepend(ligne);

                    // reset form
                    resetForm();

                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert("'Erreur d'enregistremet'");
                // console.log("Erreur: impossible de charger les sites ", textStatus);
            }
        });
    });

    // suppression d'une ville
    $('html').on('click', '.del-site', function(e){
        e.preventDefault();
        let data = {
            _method: "DELETE",
            _token: csrftoken()
        };
        // console.log(data);
        if(confirm('Vous êtes sur de vouloir supprimer ce site?')){
            $(this).parents('tr').remove();
            $.post($(this).attr('href'), data);
        }
    });

    //get token
    function csrftoken(){
        return $('meta[name="csrf-token"]').attr('content');
    }

    function resetForm(){
        $('#pac-input').val('');
        $('.pac-form').trigger("reset");
        $('.controls-btn').prop( "disabled", false );
    }


</script>
</body>
</html>
