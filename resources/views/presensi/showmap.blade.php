<!-- menampilkan peta absensi user dibagian admin -->
<style>
    #map {
        height: 180px;
    }

</style>

<div id="map"></div>
<script>
    var lokasi = "{{ $presensi->lokasi_in }}"
    var lok = lokasi.split(",");
    var latitude = lok[0];
    var longitude = lok[1];
    alert(latitude);
    var map = L.map('map').setView([latitude, longitude], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([latitude, longitude]).addTo(map);
    var circle = L.circle([-7.7856768,110.3757312], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        //mengatur jarak radius, satuan meter
        radius: 500
    }).addTo(map);
    var popup = L.popup()
        .setLatLng([latitude, longitude])
        .setContent("{{ $presensi->nama_lengkap }}")
        .openOn(map);

</script>