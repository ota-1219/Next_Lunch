const showDetailMap = function (element, lat = 35.733688, lng = 139.715643, restaurantName) {
    //マーカーの情報
    let markerData = new Array();
    // markerData.push({
    //     lat: '35.733688',
    //     lng: '139.715643',
    //     content: '本社' //情報ウィンドウの内容
    // });
    markerData.push({
        lat: lat,
        lng: lng,
        content: restaurantName
    });

    const restaurantLatLng = new google.maps.LatLng(lat, lng);
    const Options = {
        zoom: 18, //地図の縮尺値
        center: restaurantLatLng, //地図の中心座標
        mapTypeId: "roadmap" //地図の種類
    };
    const map = new google.maps.Map(element, Options);

    let markers = new Array();
    //マーカーを配置
    for (i = 0; i < markerData.length; i++) {
        markers[i] = new google.maps.Marker({
            position: new google.maps.LatLng(markerData[i].lat, markerData[i].lng),
            map: map
        });
        markerInfo(markers[i], markerData[i].content);
    }
}
function markerInfo(marker, name) {
    new google.maps.InfoWindow({
        content: name
    }).open(marker.getMap(), marker);
}
