<?php



if (!function_exists('getTimezone')) {
    function getTimezone()
    {

        $timezones = [
            "Africa/Abidjan",
            "Africa/Accra",
            "Africa/Addis_Ababa",
            "Africa/Algiers",
            "Africa/Asmara",
            "Africa/Bamako",
            "Africa/Bangui",
            "Africa/Banjul",
            "Africa/Bujumbura",
            "Africa/Cairo",
            "Africa/Casablanca",
            "Africa/Conakry",
            "Africa/Dakar",
            "Africa/Dar_es_Salaam",
            "Africa/Djibouti",
            "Africa/Douala",
            "Africa/El_Aaiun",
            "Africa/Johannesburg",
            "Africa/Juba",
            "Africa/Kampala",
            "Africa/Khartoum",
            "Africa/Kigali",
            "Africa/Kinshasa",
            "Africa/Lagos",
            "Africa/Libreville",
            "Africa/Luanda",
            "Africa/Lubumbashi",
            "Africa/Lusaka",
            "Africa/Malabo",
            "Africa/Maputo",
            "Africa/Maseru",
            "Africa/Monrovia",
            "Africa/Nairobi",
            "Africa/Ndjamena",
            "Africa/Niamey",
            "Africa/Nouakchott",
            "Africa/Ouagadougou",
            "Africa/Porto-Novo",
            "Africa/Sao_Tome",
            "Africa/Tripoli",
            "Africa/Tunis",
            "Africa/Windhoek",
            "America/Adak",
            "America/Anchorage",
            "America/Anguilla",
            "America/Antigua",
            "America/Araguaina",
            "America/Argentina/Buenos_Aires",
            "America/Argentina/Catamarca",
            "America/Argentina/ComodRivadavia",
            "America/Argentina/Cordoba",
            "America/Argentina/Jujuy",
            "America/Argentina/La_Rioja",
            "America/Argentina/Mendoza",
            "America/Argentina/Rio_Gallegos",
            "America/Argentina/Salta",
            "America/Argentina/San_Juan",
            "America/Argentina/San_Luis",
            "America/Argentina/Tucuman",
            "America/Argentina/Ushuaia",
            "America/Aruba",
            "America/Asuncion",
            "America/Atikokan",
            "America/Barbados",
            "America/Belem",
            "America/Belize",
            "America/Blanc-Sablon",
            "America/Boa_Vista",
            "America/Bogota",
            "America/Boise",
            // Add more timezones as needed
        ];

        return  $timezones;
    }




    if (!function_exists('getCurrancy')) {
        function  getCurrancy()
        {
            $currencySymbols = [
                "SAR" => "ر.س",
                "AED" => "د.إ",
                "QAR" => "ر.ق",
                "KWD" => "د.ك",
                "BHD" => ".د.ب",
                "OMR" => "ر.ع.",
                "JOD" => "د.ا",
                "LBP" => "ل.ل",
                "IQD" => "د.ع",
                "EGP" => "ج.م",
                "YER" => "﷼",
                'Dollar' => "دولار",
            ];
            return  $currencySymbols;
        }
    }

    if (!function_exists('getDateformat')) {
        function  getDateformat()
        {
            $dateFormats = [
                "MM/DD/YYYY",
                "DD/MM/YYYY",
                "YYYY/MM/DD",
                "DD/MM/YYYY",
                "DD/MM/YYYY"
            ];

            return $dateFormats;
        }
    }

    if (!function_exists('getTimeformat')) {
        function  getTimeformat()
        {
            $timeFormats = [
                "H:i:s",
                "H:i",
                "H:i:sa",
                "h:i",
                "h:i:sa",
                'HH:mm a',
            ];

            return $timeFormats;
        }
    }
}
