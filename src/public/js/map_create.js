$(function () {
    let input_lat = parseFloat($('#end_lat').val());
    let input_lng = parseFloat($('#end_lng').val());
    console.log('inputLatLng:' + input_lat + ', ' + input_lng);


    if (isNaN(input_lat)) {
        input_lat = 35.733688;
    }
    if (isNaN(input_lng)) {
        input_lng = 139.715643;
    }

    const MyLatLng = new google.maps.LatLng(input_lat, input_lng);
    console.log(MyLatLng);
    const Options = {
        zoom: 18, //地図の縮尺値
        center: MyLatLng, //地図の中心座標
        mapTypeId: "roadmap" //地図の種類
    };
    const map = new google.maps.Map(document.getElementById("map"), Options);

    // マーカー表示
    const marker = new google.maps.Marker({
        position: MyLatLng,
        map: map
    });

    // Mapをクリックする時の動作
    map.addListener("click", function (e) {
        // console.log("lat: " + e.latLng.lat());
        // console.log("lng: " + e.latLng.lng());
        console.log("(lat,lng): " + e.latLng.toString());

        // クリックしたとこにマーカーを移動
        marker.setPosition(e.latLng);
        this.panTo(e.latLng); //クリックする場所をMapの中心にする

        // テキストボックスにLatLng表示
        document.getElementById("end_lat").value = e.latLng.lat();
        document.getElementById("end_lng").value = e.latLng.lng();
    });
});
