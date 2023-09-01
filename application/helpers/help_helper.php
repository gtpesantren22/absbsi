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
