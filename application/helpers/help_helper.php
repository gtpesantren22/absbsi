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
