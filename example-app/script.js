let map;

async function initMap() {
  // The location of Uluru
  const position = {
    lat: 36.778259,
    lng: -119.417931
  };
  
  // Request needed libraries.
  //@ts-ignore
  const {
    Map
  } = await google.maps.importLibrary("maps");
  const {
    AdvancedMarkerElement
  } = await google.maps.importLibrary("marker");

  // The map, centered at Uluru
  map = new Map(document.getElementById("map"), {
    zoom: 4,
    center: position,
    mapId: "map",
  });
  let  marker = new google.maps.Marker({
    position: position,
    map,
    icon: "https://img.icons8.com/glassmorphism/48/marker.png"
  });

  let  marker2 = new google.maps.Marker({
    position: position,
    map,
    icon: "https://img.icons8.com/glassmorphism/47/marker.png"
  });
  // The marker, positioned at Uluru
  /*const marker = new AdvancedMarkerElement({
    map: map,
    position: position,
    title: "Uluru",
   
  });*/
}

initMap();