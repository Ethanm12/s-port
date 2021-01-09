<template>
  <div class="map"></div>
</template>

<script>
import gmapsInit from "../utils/gmaps.js";

export default {
  name: "App",
  async mounted() {
    try {
      let styles = [
        //fill for streets and labels
        {
          featureType: "all",
          elementType: "labels.text.fill",
          stylers: [{ saturation: 0 }, { color: "#746855" }, { lightness: 0 }]
        },
        //outline for streets and labels
        {
          featureType: "all",
          elementType: "labels.text.stroke",
          stylers: [
            { visibility: "on" },
            { color: "#242f3e" },
            { lightness: 0 }
          ]
        },
        //markers for shops/businesses etc
        {
          featureType: "all",
          elementType: "labels.icon",
          stylers: [{ visibility: "off" }]
        },
        //dotted lines separating provinces
        {
          featureType: "administrative",
          elementType: "geometry.fill",
          stylers: [{ color: "#000000" }, { lightness: 20 }]
        },
        {
          featureType: "administrative",
          elementType: "geometry.stroke",
          stylers: [{ color: "#000000" }, { lightness: 17 }, { weight: 1.2 }]
        },
        //background colour
        {
          featureType: "landscape",
          elementType: "geometry",
          stylers: [{ color: "#242f3e" }, { lightness: 0 }]
        },
        //points of interest
        {
          featureType: "poi",
          elementType: "geometry",
          stylers: [{ color: "#000000" }, { lightness: 35 }]
        },
        //points of interest can be further broken down
        {
          featureType: "poi.park",
          elementType: "geometry",
          stylers: [{ color: "#263c3f" }, { lightness: 0 }]
        },
        {
          featureType: "poi.park",
          elementType: "labels.text.fill",
          stylers: [{ color: "#6b9a76" }]
        },
        //main roads fill
        {
          featureType: "road.highway",
          elementType: "geometry.fill",
          stylers: [{ color: "#746855" }, { lightness: 17 }]
        },
        //main roads outline
        {
          featureType: "road.highway",
          elementType: "geometry.stroke",
          stylers: [{ color: "#1f2835" }, { lightness: 0 }, { weight: 0.2 }]
        },
        //arterial roads
        {
          featureType: "road.arterial",
          elementType: "geometry",
          stylers: [{ color: "#38414e" }, { lightness: 18 }]
        },
        //normal roads
        {
          featureType: "road.local",
          elementType: "geometry",
          stylers: [{ color: "#38414e" }, { lightness: 16 }]
        },
        {
          featureType: "road",
          elementType: "geometry.stroke",
          stylers: [{ color: "#212a37" }]
        },
        {
          featureType: "road",
          elementType: "labels.text.fill",
          stylers: [{ color: "#9ca5b3" }]
        },
        //trainlines
        {
          featureType: "transit",
          elementType: "geometry",
          stylers: [{ color: "#2f3948" }, { lightness: 19 }]
        },
        {
          featureType: "transit.station",
          elementType: "labels.text.fill",
          stylers: [{ color: "#d59563" }]
        },
        //water
        {
          featureType: "water",
          elementType: "geometry",
          stylers: [{ color: "#17263c" }]
        },
        {
          featureType: "water",
          elementType: "labels.text.fill",
          stylers: [{ color: "#515c6d" }]
        },
        {
          featureType: "water",
          elementType: "labels.text.stroke",
          stylers: [{ color: "#17263c" }]
        }
      ];

      const google = await gmapsInit();
      const geocoder = new google.maps.Geocoder();
      const map = new google.maps.Map(this.$el, {
        zoom: 15,
        zoomControl: false,
        scaleControl: false,
        scrollwheel: false,
        disableDoubleClickZoom: true,
        draggable: true,
        mapTypeControl: false,
        fullscreenControl: false,
        streetViewControl: false,
        styles: styles
      });

      //enter address here
      geocoder.geocode(
        { address: "442 moray place dunedin" },
        (results, status) => {
          if (status !== "OK" || !results[0]) {
            throw new Error(status);
          }

          map.setCenter(results[0].geometry.location);
          // The following method (fitBounds) will override the zoom level set above
          // map.fitBounds(results[0].geometry.viewport);

          // Add custom map-pin icon here
          const image = '/images/boilerplate_map_pin.png';

          const marker = new google.maps.Marker({
            position: results[0].geometry.location,
            map: map,
            //title will appear as tool-tip
            title: 'Location',
            icon: image
          });

        }
      );
    } catch (error) {
      console.error(error);
    }
  }
};
</script>

<style>
.map {
  width: 100vw;
  height: 400px;
}
</style>