<div id="map-wrapper" class="map-wrapper">

	<?php if ( get_field( 'map__locations' ) ) : ?>
		
		<?php $markerLink 	= get_template_directory_uri() . '/assets/img/marker.png'; ?> 
		<?php $locations 	= array(); ?>

		<?php while ( the_repeater_field( 'map__locations' ) ) : ?>
			<?php $location 		= get_sub_field( 'location' ); ?>
			<?php $lat 				= $location['lat'] ?>
			<?php $lng 				= $location['lng'] ?>
			<?php $image 			= get_sub_field( 'image' ); ?>
			<?php $title 			= get_sub_field( 'title' ); ?>
			<?php $address 			= get_sub_field( 'address' ); ?>
			<?php $opening 			= get_sub_field( 'opening' ); ?>
			<?php $opening_weekend 	= get_sub_field( 'opening_weekend' ); ?>
			<?php $phone 			= get_sub_field( 'phone' ); ?>
			<?php $param 			= get_sub_field( 'url_param' ); ?>
			<?php $map_directions  	= get_sub_field( 'map_directions' ); ?>

			<?php 
				$locations[] = array(
					'location' 			=> $location,
					'lat' 				=> $lat,
					'lng' 				=> $lng,
					'image' 			=> $image,
					'title' 			=> $title,
					'address' 			=> $address,
					'opening' 			=> $opening,
					'opening_weekend' 	=> $opening_weekend,
					'phone' 			=> $phone,
					'param' 			=> $param,
					'directions' 		=> $map_directions,
				);
			?>

		<?php endwhile; ?>

	<?php endif; ?>
	
	<?php if ( get_field('map_headline') ): ?>
	<div class="uk-container uk-container-large">
		<div class="map__title">
			<h3 class="uk-heading-line uk-text-center section-title uk-margin-remove"><?php the_field('map_headline'); ?></h3>		
		</div>
	</div>
	<?php endif; ?>

	<div id="map"></div>

    <script type="text/javascript">

		var locations 	= JSON.parse('<?php echo json_encode( $locations ); ?>');
		var markers 	= [];

		function initMap() {
			
			var myLatLng = {
				lat: locations[0].lat,
				lng: locations[0].lng
			};
			
			var markerIcon = '<?php echo $markerLink ?>';

			var map = new google.maps.Map(document.getElementById('map'), {
				center: myLatLng,
				zoom: 11,
				disableDefaultUI: true,
				styles: 
				[
					{
						"elementType": "geometry",
						"stylers": [
					{
						"color": "#ebe3cd"
					}
					]
					},
					{
						"elementType": "labels.text.fill",
						"stylers": [
						{
							"color": "#523735"
						}
						]
					},
					{
						"elementType": "labels.text.stroke",
						"stylers": [
						{
							"color": "#f5f1e6"
						}
						]
					},
					{
						"featureType": "administrative",
						"elementType": "geometry.stroke",
						"stylers": [
						{
							"color": "#c9b2a6"
						}
						]
					},
					{
						"featureType": "administrative.land_parcel",
						"elementType": "geometry.stroke",
						"stylers": [
						{
							"color": "#dcd2be"
						}
						]
					},
					{
						"featureType": "administrative.land_parcel",
						"elementType": "labels.text.fill",
						"stylers": [
						{
							"color": "#ae9e90"
						}
						]
					},
					{
						"featureType": "landscape.natural",
						"elementType": "geometry",
						"stylers": [
						{
							"color": "#dfd2ae"
						}
						]
					},
					{
						"featureType": "poi",
						"elementType": "geometry",
						"stylers": [
						{
							"color": "#dfd2ae"
						}
						]
					},
					{
						"featureType": "poi",
						"elementType": "labels.icon",
						"stylers": [
						{
							"visibility": "off"
						}
						]
					},
					{
						"featureType": "poi",
						"elementType": "labels.text.fill",
						"stylers": [
						{
							"color": "#93817c"
						}
						]
					},
					{
						"featureType": "poi.park",
						"elementType": "geometry.fill",
						"stylers": [
						{
							"color": "#a5b076"
						}
						]
					},
					{
						"featureType": "poi.park",
						"elementType": "labels.text.fill",
						"stylers": [
						{
							"color": "#447530"
						}
						]
					},
					{
						"featureType": "road",
						"elementType": "geometry",
						"stylers": [
						{
							"color": "#f5f1e6"
						}
						]
					},
					{
						"featureType": "road.arterial",
						"elementType": "geometry",
						"stylers": [
						{
							"color": "#fdfcf8"
						}
						]
					},
					{
						"featureType": "road.highway",
						"elementType": "geometry",
						"stylers": [
						{
							"color": "#f8c967"
						}
						]
					},
					{
						"featureType": "road.highway",
						"elementType": "geometry.stroke",
						"stylers": [
						{
							"color": "#e9bc62"
						}
						]
					},
					{
						"featureType": "road.highway",
						"elementType": "labels.icon",
						"stylers": [
						{
							"visibility": "off"
						}
						]
					},
					{
						"featureType": "road.highway.controlled_access",
						"elementType": "geometry",
						"stylers": [
						{
							"color": "#e98d58"
						}
						]
					},
					{
						"featureType": "road.highway.controlled_access",
						"elementType": "geometry.stroke",
						"stylers": [
						{
							"color": "#db8555"
						}
						]
					},
					{
						"featureType": "road.local",
						"elementType": "labels.text.fill",
						"stylers": [
						{
							"color": "#806b63"
						}
						]
					},
					{
						"featureType": "transit",
						"elementType": "labels.icon",
						"stylers": [
						{
							"visibility": "off"
						}
						]
					},
					{
						"featureType": "transit.line",
						"elementType": "geometry",
						"stylers": [
						{
							"color": "#dfd2ae"
						}
						]
					},
					{
						"featureType": "transit.line",
						"elementType": "labels.text.fill",
						"stylers": [
						{
							"color": "#8f7d77"
						}
						]
					},
					{
						"featureType": "transit.line",
						"elementType": "labels.text.stroke",
						"stylers": [
						{
							"color": "#ebe3cd"
						}
						]
					},
					{
						"featureType": "transit.station",
						"elementType": "geometry",
						"stylers": [
						{
							"color": "#dfd2ae"
						}
						]
					},
					{
						"featureType": "water",
						"elementType": "geometry.fill",
						"stylers": [
						{
							"color": "#b9d3c2"
						}
						]
					},
					{
						"featureType": "water",
						"elementType": "labels.text.fill",
						"stylers": [
						{
							"color": "#92998d"
						}
						]
					}
				]
			});

			var displayLocations 	= [];

			for (i = 0; i < locations.length; i++) {
				displayLocations.push(['<div id="content"><div id="siteNotice"></div><div id="bodyContent"><img class="content-image" src="' + locations[i].image + '"><p><b style="font-family: Poppins, sans-serif; font-size: 14px; color: #493f39; font-weight: bold; padding: 0 10px">' + locations[i].title +' <br> </b><p style="font-family: Poppins, sans-serif;font-size: 14px; color: #493f39; padding: 0 10px;">' + locations[i].address + '</p><p style="font-family: Poppins, sans-serif; font-size: 14px; color: #493f39; padding: 0 10px">'+ locations[i].opening +'</p><p style="font-family: Poppins, sans-serif; font-size: 14px; color: #493f39; padding: 0 10px">'+ locations[i].opening_weekend +'</p><p style="font-family: Poppins, sans-serif; font-size: 14px; color: #493f39; padding: 0 10px;">'+ locations[i].phone +'</p><p style="font-family: Poppins, sans-serif;font-size: 14px; color: #493f39; padding: 0 10px;"><a style="color: #bf883b; font-weight: 500;" target="_blank" href="'+locations[i].directions+'">Jak dojechać</a></p></div></div>', locations[i].lat, locations[i].lng, markerIcon ]);
			}

			var marker, i;
			var infowindow = new google.maps.InfoWindow();
			//add marker to each locations
			for (i = 0; i < displayLocations.length; i++) {

				marker = new google.maps.Marker({
					position: new google.maps.LatLng(displayLocations[i][1], displayLocations[i][2]),
					map: map,
					icon: displayLocations[i][3]
				});
				//click function to marker, pops up infowindow
				google.maps.event.addListener(marker, 'click', (function (marker, i) {
					return function () {
						infowindow.setContent(displayLocations[i][0]);
						infowindow.open(map, marker);
					}
				})(marker, i));
				
				markers.push(marker);
			}

			google.maps.event.addListener(infowindow, 'closeclick', function() {
   				map.panTo(myLatLng);
			});

			<?php if ( isset( $_GET['location'] ) ) : ?>

				var choosed_location = '<?php echo $_GET['location']; ?>';

				for (i = 0; i < locations.length; i++) {
					if ( choosed_location == locations[i].param ) {
						infowindow.setContent(displayLocations[i][0]);
						infowindow.open(map, markers[i]);
					}
				}

			<?php endif; ?>

		}
      
	</script>
	
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBsU2iv51eXv3Fdf3_MB00ElspKjUh7bzs&callback=initMap">
    </script>

</div>