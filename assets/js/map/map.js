var map = L.map("map").setView([24.0, 90.0], 7);

L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

const getLocationFromBrowser = () => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;
      
      showUserLocationOnMap(latitude, longitude);
    });
  } else {
    alert("Geolocation is not supported by this browser.");
  }
};
const showUserLocationOnMap = (latitude, longitude) => {
  console.log(typeof(latitude),"ASdasd",latitude, longitude);
  // Update visual appearance (optional)
  document.getElementById("map").style.opacity = 1; // Restore opacity
  document.getElementById("map").style.pointerEvents = "auto"; // Enable pointer events
  
  map.flyTo([latitude, longitude], 17, { draggable: true });
  document.getElementById("LatLong").value = `${latitude}, ${longitude}`;

  // Create a draggable marker
  var marker = L.marker([latitude, longitude], { draggable: true }).addTo(map);

  // Event listener for the marker dragend event
  marker.on("drag", function (event) {
    var newPosition = event.target.getLatLng();

    // Update map view to the new marker position
    map.setView(newPosition);
  });
  marker.on("dragend", function (event) {
    const { lat, lng } = event.target.getLatLng();
    document.getElementById("LatLong").value = `${lat}, ${lng}`;
  });
};

