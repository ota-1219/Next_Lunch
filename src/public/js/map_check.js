var $script = $("#script");
var result = JSON.parse($script.attr("data-param"));
//確認
console.log(result);

$(function () {
    var MyLatLng = new google.maps.LatLng(result[0], result[1]);
    var Options = {
        zoom: 18, //地図の縮尺値
        center: MyLatLng, //地図の中心座標
        mapTypeId: "roadmap" //地図の種類
    };
    var map = new google.maps.Map(document.getElementById("map"), Options);

    // マーカー表示
    var marker = new google.maps.Marker({
        position: MyLatLng,
        map: map
    });
});
