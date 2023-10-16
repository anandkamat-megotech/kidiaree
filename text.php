<!DOCTYPE html>
<html>
<head>
  <title>Current ZIP Code</title>
  <script>
    window.addEventListener("DOMContentLoaded", function() {
      var zipcodeInput = document.getElementById("zipcode");

      // Check if Geolocation is supported
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          // Fetch the ZIP code based on user's location
          var latitude = position.coords.latitude;
          var longitude = position.coords.longitude;

          // Example Nominatim API endpoint for reverse geocoding
          var apiUrl = "https://nominatim.openstreetmap.org/reverse?format=json&lat=" + latitude + "&lon=" + longitude;

          // Make an AJAX request to the Nominatim API
          var xhr = new XMLHttpRequest();
          xhr.open("GET", apiUrl, true);
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              var response = JSON.parse(xhr.responseText);
              var zipcode = response.address.postcode;
              zipcodeInput.value = zipcode;
            }
          };
          xhr.send();
        });
      }
    });
  </script>
</head>
<body>
  <form>
    <label for="zipcode">ZIP Code:</label>
    <input type="text" id="zipcode" name="zipcode" readonly>
  </form>
</body>
</html>
