<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Wilayah</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2 class="mb-3">Pilih Data Wilayah</h2>

    <div class="row mb-3">
        <div class="col-md-6">
            <label>Provinsi</label>
            <select id="provinceSelect" class="form-select">
                <option value="">Pilih Provinsi</option>
            </select>
        </div>
    </div>

    <div class="row mb-3" id="regencyContainer" style="display: none;">
        <div class="col-md-6">
            <label>Kabupaten/Kota</label>
            <select id="regencySelect" class="form-select">
                <option value="">Pilih Kabupaten/Kota</option>
            </select>
        </div>
    </div>


    <div class="row mb-3" id="districtContainer" style="display: none;">
        <div class="col-md-6">
            <label>Kecamatan</label>
            <select id="districtSelect" class="form-select">
                <option value="">Pilih Kecamatan</option>
            </select>
        </div>
    </div>

    <div class="row mb-3" id="villageContainer" style="display: none;">
        <div class="col-md-6">
            <label>Desa/Kelurahan</label>
            <select id="villageSelect" class="form-select">
                <option value="">Pilih Desa/Kelurahan</option>
            </select>
        </div>
    </div>


    <div class="row mb-3" id="weatherButtonContainer" style="display: none;">
        <div class="col-md-6">
            <button id="weatherButton" class="btn btn-primary">Lihat Cuaca</button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function fetchData(url, params, selectElement, placeholder) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: params,
                    success: function(data) {
                        if (!Array.isArray(data)) {
                            console.error("Response bukan array:", data);
                            return;
                        }
                        selectElement.empty().append(`<option value="">${placeholder}</option>`);
                        data.forEach(item => {
                            selectElement.append(`<option value="${item.code}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading data:", status, error);
                    }
                });
            }

            fetchData('/weather/provinces', {}, $('#provinceSelect'), "Pilih Provinsi");

            $('#provinceSelect').change(function() {
                let provinceCode = $(this).val();
                $('#districtContainer, #villageContainer, #weatherButtonContainer').hide();
                if (provinceCode) {
                    $('#regencyContainer').show();
                    fetchData('/weather/regencies', { province: provinceCode }, $('#regencySelect'), "Pilih Kabupaten/Kota");
                } else {
                    $('#regencyContainer').hide();
                }
            });

            $('#regencySelect').change(function() {
                let regencyCode = $(this).val();
                $('#villageContainer, #weatherButtonContainer').hide();
                if (regencyCode) {
                    $('#districtContainer').show();
                    fetchData('/weather/districts', { regency: regencyCode }, $('#districtSelect'), "Pilih Kecamatan");
                } else {
                    $('#districtContainer').hide();
                }
            });

            $('#districtSelect').change(function() {
                let districtCode = $(this).val();
                if (districtCode) {
                    $('#villageContainer').show();
                    fetchData('/weather/villages', { district: districtCode }, $('#villageSelect'), "Pilih Desa/Kelurahan");
                } else {
                    $('#villageContainer').hide();
                }
            });

            $('#villageSelect').change(function() {
                let villageCode = $(this).val();
                if (villageCode) {
                    $('#weatherButtonContainer').show();
                    $('#weatherButton').attr('data-code', villageCode);
                } else {
                    $('#weatherButtonContainer').hide();
                }
            });

            $('#weatherButton').click(function() {
                let kodeWilayah = $(this).attr('data-code');
                if (kodeWilayah) {
                    window.location.href = `/weather/${kodeWilayah}`;
                }
            });
        });
    </script>

</body>
</html>
