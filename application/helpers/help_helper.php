<?php
function translateDay($englishDay, $language)
{
    $translations = array(
        "Sunday" => array(
            "id" => "Ahad",
            "es" => "Domingo",
            // Tambahkan terjemahan ke bahasa lain di sini
        ),
        "Monday" => array(
            "id" => "Senin",
            "es" => "Lunes",
            // Tambahkan terjemahan ke bahasa lain di sini
        ),
        "Tuesday" => array(
            "id" => "Selasa",
            "es" => "Martes",
            // Tambahkan terjemahan ke bahasa lain di sini
        ),
        "Wednesday" => array(
            "id" => "Rabu",
            "es" => "Miércoles",
            // Tambahkan terjemahan ke bahasa lain di sini
        ),
        "Thursday" => array(
            "id" => "Kamis",
            "es" => "Jueves",
            // Tambahkan terjemahan ke bahasa lain di sini
        ),
        "Friday" => array(
            "id" => "Jum'at",
            "es" => "Viernes",
            // Tambahkan terjemahan ke bahasa lain di sini
        ),
        "Saturday" => array(
            "id" => "Sabtu",
            "es" => "Sábado",
            // Tambahkan terjemahan ke bahasa lain di sini
        )
    );

    return $translations[$englishDay][$language] ?? $englishDay;
}

function kirim_person($no_hp, $pesan)
{
    $curl2 = curl_init();
    curl_setopt_array(
        $curl2,
        array(
            CURLOPT_URL => 'http://191.101.3.115:3000/api/sendMessage',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'apiKey=66f67201ef1de1c48d5bba3257e46839&phone=' . $no_hp . '&message=' . $pesan,
        )
    );
    $response = curl_exec($curl2);
    curl_close($curl2);
}

function kirim_group($id_group, $pesan)
{
    $curl2 = curl_init();
    curl_setopt_array(
        $curl2,
        array(
            CURLOPT_URL => 'http://191.101.3.115:3000/api/sendMessageGroup',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'apiKey=66f67201ef1de1c48d5bba3257e46839&id_group=' . $id_group . '&message=' . $pesan,
        )
    );
    $response = curl_exec($curl2);
    curl_close($curl2);
}

function cek_nomor($no_hp)
{
    $curl2 = curl_init();
    curl_setopt_array(
        $curl2,
        array(
            CURLOPT_URL => 'http://191.101.3.115:3000/api/isRegisteredNumber',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'apiKey=66f67201ef1de1c48d5bba3257e46839&phone=' . $no_hp,
        )
    );
    $response = curl_exec($curl2);
    return $response;

    curl_close($curl2);
}

function bulan($bulan)
{
    switch ($bulan) {
        case 0:
            $bulan = "";
            break;
        case 1:
            $bulan = "Januari";
            break;
        case 2:
            $bulan = "Februari";
            break;
        case 3:
            $bulan = "Maret";
            break;
        case 4:
            $bulan = "April";
            break;
        case 5:
            $bulan = "Mei";
            break;
        case 6:
            $bulan = "Juni";
            break;
        case 7:
            $bulan = "Juli";
            break;
        case 8:
            $bulan = "Agustus";
            break;
        case 9:
            $bulan = "September";
            break;
        case 10:
            $bulan = "Oktober";
            break;
        case 11:
            $bulan = "November";
            break;
        case 12:
            $bulan = "Desember";
            break;
        default:
            $bulan = Date('F');
            break;
    }
    return $bulan;
}

function colorCell($grid)
{
    if ($grid > 48) {
        return '990000';
    } elseif ($grid > 24 && $grid <= 48) {
        return 'FF0000';
    } elseif ($grid > 16 && $grid <= 24) {
        return 'FFFF00';
    } elseif ($grid > 8 && $grid <= 16) {
        return '009999';
    } elseif ($grid > 0 && $grid <= 8) {
        return '0099FF';
    } elseif ($grid < 1) {
        return 'FFFFFF';
    }
}
