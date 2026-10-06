var map;
var kelurahan = document.getElementById("nama_kelurahan");
var kecamatan = document.getElementById("nama_kecamatan");
var deskripsi = document.getElementById("deskripsi");

function getKecamatanByMap(datas) {
    const localityFeatures = datas.features.filter((feature) =>
        feature.place_type.includes("locality")
    );
    const localityID = localityFeatures[0].id;
    const localityFeature = datas.features.find(
        (feature) => feature.id === localityID
    );
    const localityData = localityFeature.place_name;

    return localityData.split(",")[0];
}

function getKelurahanByMap(datas) {
    const neighborhoodFeatures = datas.features.filter((feature) =>
        feature.place_type.includes("neighborhood")
    );
    const neighborhoodId = neighborhoodFeatures[0].id;
    const neighborhoodFeature = datas.features.find(
        (feature) => feature.id === neighborhoodId
    );
    const neighborhoodData = neighborhoodFeature.place_name;

    return neighborhoodData.split(",")[0];
}

function getJalanByMap(datas) {
    try {
        const poiFeatures = datas.features.filter((feature) =>
            feature.place_type.includes("poi")
        );

        const poiId = poiFeatures[0].id;
        const poiFeature = datas.features.find(
            (feature) => feature.id === poiId
        );
        const data = {
            error: false,
            deksripsi: poiFeature.place_name,
        };

        return data;
    } catch (error) {
        const data = {
            error: true,
        };
        return data;
    }
}

function getAddressFromLatLng(latitude, longitude) {
    // Make a request to the Mapbox Geocoding API to get the address
    fetch(
        `https://api.mapbox.com/geocoding/v5/mapbox.places/${longitude},${latitude}.json?access_token=ISI_TOKEN_MAPBOX_KAMU`
    )
        .then((response) => response.json())
        .then((datas) => {
            var getJalanErrorMessage = document.getElementById("jalan-error");
            // console.log(datas);
            if (getJalanByMap(datas).error === true) {
                deskripsi.value = "";
                getJalanErrorMessage.innerHTML =
                    "Pastikan memilih titik yang benar atau masukkan secara manual";
            } else {
                getJalanErrorMessage.innerHTML = "";
                deskripsi.value = getJalanByMap(datas).deksripsi;
            }

            kecamatan.value = getKecamatanByMap(datas);
            // Cek
            $.ajax({
                url: `/cek-lokasi`,
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: {
                    nama_kelurahan: getKelurahanByMap(datas),
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response) {
                        if (response.submit && response.is_kecamatan === 1) {
                            $("#sumbit-tambah-lokasi").prop("disabled", false);
                            $("#kelurahan-exist").html("");
                            $("#isKecamatanFalse").prop("checked", true);
                            $("#isKecamatanTrue").prop("disabled", true);
                            $("#isKelurahanKontainer").css(
                                "display",
                                "none"
                            );
                        } else if (
                            response.submit &&
                            response.is_kecamatan === 0
                        ) {
                            $("#sumbit-tambah-lokasi").prop("disabled", true);
                            $("#kelurahan-exist").html(
                                "Kontainer di kelurahan dan kecamatan sudah ada"
                            );
                            $("#isKecamatanFalse").prop("disabled", true);
                            $("#isKecamatanTrue").prop("checked", true);
                            $("#isKelurahanKontainer").css(
                                "display",
                                "none"
                            );
                        } else if (response.submit && response.is_kecamatan) {
                            $("#sumbit-tambah-lokasi").prop("disabled", false);
                            $("#kelurahan-exist").html("");
                            $("#isKelurahanKontainer").css(
                                "display",
                                "block"
                            );
                        } else {
                            $("#sumbit-tambah-lokasi").prop("disabled", false);
                            $("#kelurahan-exist").html(
                                "Kontainer di kelurahan dan kecamatan sudah ada"
                            );
                            $("#isKelurahanKontainer").css(
                                "display",
                                "block"
                            );
                        }
                    } else {
                        $("#kelurahan-exist").html("");
                    }
                },
                error: function (e) {
                    console.log(e);
                    // alert("An error occurred while checking the username");
                },
            });

            kelurahan.value = getKelurahanByMap(datas);
            // kecamatan = getKecamatanByMap(datas)
            // Log the address to the console
        })
        .catch((error) => {
            console.error(error);
        });
    // return data;
}

function GetMap() {
    try {
        var map = new Microsoft.Maps.Map("#maps", {
            credentials:
                "AlUje-BfB7q-XcFYespJdjtmZY9wrhc1ismON5fsYXgvCUfb2hzSfiEN8UwdqqJ9",
        });

        map.setView({
            mapTypeId: Microsoft.Maps.MapTypeId.aerial,
        });

        Microsoft.Maps.Events.addHandler(map, "click", function (e) {
            var location = e.location;
            var latitude = location.latitude;
            var longitude = location.longitude;
            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;
            const koordinat = latitude + ", " + longitude;
            document.querySelector("#koordinat").value = koordinat;
            getAddressFromLatLng(latitude, longitude);
        });
    } catch (error) {
        
    }
}
