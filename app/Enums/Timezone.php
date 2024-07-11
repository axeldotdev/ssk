<?php

namespace App\Enums;

enum Timezone: string
{
    case EuropeAmsterdam = 'europe-amsterdam';
    case EuropeAndorra = 'europe-andorra';
    case EuropeAstrakhan = 'europe-astrakhan';
    case EuropeAthens = 'europe-athens';
    case EuropeBelgrade = 'europe-belgrade';
    case EuropeBerlin = 'europe-berlin';
    case EuropeBratislava = 'europe-bratislava';
    case EuropeBrussels = 'europe-brussels';
    case EuropeBucharest = 'europe-bucharest';
    case EuropeBudapest = 'europe-budapest';
    case EuropeBusingen = 'europe-busingen';
    case EuropeChisinau = 'europe-chisinau';
    case EuropeCopenhagen = 'europe-copenhagen';
    case EuropeDublin = 'europe-dublin';
    case EuropeGibraltar = 'europe-gibraltar';
    case EuropeGuernsey = 'europe-guernsey';
    case EuropeHelsinki = 'europe-helsinki';
    case EuropeIsle_of_Man = 'europe-isle-of-man';
    case EuropeIstanbul = 'europe-istanbul';
    case EuropeJersey = 'europe-jersey';
    case EuropeKaliningrad = 'europe-kaliningrad';
    case EuropeKirov = 'europe-kirov';
    case EuropeKyiv = 'europe-kyiv';
    case EuropeLisbon = 'europe-lisbon';
    case EuropeLjubljana = 'europe-ljubljana';
    case EuropeLondon = 'europe-london';
    case EuropeLuxembourg = 'europe-luxembourg';
    case EuropeMadrid = 'europe-madrid';
    case EuropeMalta = 'europe-malta';
    case EuropeMariehamn = 'europe-mariehamn';
    case EuropeMinsk = 'europe-minsk';
    case EuropeMonaco = 'europe-monaco';
    case EuropeMoscow = 'europe-moscow';
    case EuropeOslo = 'europe-oslo';
    case EuropeParis = 'europe-paris';
    case EuropePodgorica = 'europe-podgorica';
    case EuropePrague = 'europe-prague';
    case EuropeRiga = 'europe-riga';
    case EuropeRome = 'europe-rome';
    case EuropeSamara = 'europe-samara';
    case EuropeSanMarino = 'europe-san-marino';
    case EuropeSarajevo = 'europe-sarajevo';
    case EuropeSaratov = 'europe-saratov';
    case EuropeSimferopol = 'europe-simferopol';
    case EuropeSkopje = 'europe-skopje';
    case EuropeSofia = 'europe-sofia';
    case EuropeStockholm = 'europe-stockholm';
    case EuropeTallinn = 'europe-tallinn';
    case EuropeTirane = 'europe-tirane';
    case EuropeUlyanovsk = 'europe-ulyanovsk';
    case EuropeVaduz = 'europe-vaduz';
    case EuropeVatican = 'europe-vatican';
    case EuropeVienna = 'europe-vienna';
    case EuropeVilnius = 'europe-vilnius';
    case EuropeVolgograd = 'europe-volgograd';
    case EuropeWarsaw = 'europe-warsaw';
    case EuropeZagreb = 'europe-zagreb';
    case EuropeZurich = 'europe-zurich';

    public static function list(): array
    {
        $timezones = [];

        foreach (self::cases() as $timezone) {
            $timezones[$timezone->value] = $timezone->name();
        }

        return $timezones;
    }

    public function name(): string
    {
        return match ($this) {
            self::EuropeAmsterdam => 'Europe/Amsterdam',
            self::EuropeAndorra => 'Europe/Andorra',
            self::EuropeAstrakhan => 'Europe/Astrakhan',
            self::EuropeAthens => 'Europe/Athens',
            self::EuropeBelgrade => 'Europe/Belgrade',
            self::EuropeBerlin => 'Europe/Berlin',
            self::EuropeBratislava => 'Europe/Bratislava',
            self::EuropeBrussels => 'Europe/Brussels',
            self::EuropeBucharest => 'Europe/Bucharest',
            self::EuropeBudapest => 'Europe/Budapest',
            self::EuropeBusingen => 'Europe/Busingen',
            self::EuropeChisinau => 'Europe/Chisinau',
            self::EuropeCopenhagen => 'Europe/Copenhagen',
            self::EuropeDublin => 'Europe/Dublin',
            self::EuropeGibraltar => 'Europe/Gibraltar',
            self::EuropeGuernsey => 'Europe/Guernsey',
            self::EuropeHelsinki => 'Europe/Helsinki',
            self::EuropeIsle_of_Man => 'Europe/Isle_of_Man',
            self::EuropeIstanbul => 'Europe/Istanbul',
            self::EuropeJersey => 'Europe/Jersey',
            self::EuropeKaliningrad => 'Europe/Kaliningrad',
            self::EuropeKirov => 'Europe/Kirov',
            self::EuropeKyiv => 'Europe/Kyiv',
            self::EuropeLisbon => 'Europe/Lisbon',
            self::EuropeLjubljana => 'Europe/Ljubljana',
            self::EuropeLondon => 'Europe/London',
            self::EuropeLuxembourg => 'Europe/Luxembourg',
            self::EuropeMadrid => 'Europe/Madrid',
            self::EuropeMalta => 'Europe/Malta',
            self::EuropeMariehamn => 'Europe/Mariehamn',
            self::EuropeMinsk => 'Europe/Minsk',
            self::EuropeMonaco => 'Europe/Monaco',
            self::EuropeMoscow => 'Europe/Moscow',
            self::EuropeOslo => 'Europe/Oslo',
            self::EuropeParis => 'Europe/Paris',
            self::EuropePodgorica => 'Europe/Podgorica',
            self::EuropePrague => 'Europe/Prague',
            self::EuropeRiga => 'Europe/Riga',
            self::EuropeRome => 'Europe/Rome',
            self::EuropeSamara => 'Europe/Samara',
            self::EuropeSanMarino => 'Europe/San_Marino',
            self::EuropeSarajevo => 'Europe/Sarajevo',
            self::EuropeSaratov => 'Europe/Saratov',
            self::EuropeSimferopol => 'Europe/Simferopol',
            self::EuropeSkopje => 'Europe/Skopje',
            self::EuropeSofia => 'Europe/Sofia',
            self::EuropeStockholm => 'Europe/Stockholm',
            self::EuropeTallinn => 'Europe/Tallinn',
            self::EuropeTirane => 'Europe/Tirane',
            self::EuropeUlyanovsk => 'Europe/Ulyanovsk',
            self::EuropeVaduz => 'Europe/Vaduz',
            self::EuropeVatican => 'Europe/Vatican',
            self::EuropeVienna => 'Europe/Vienna',
            self::EuropeVilnius => 'Europe/Vilnius',
            self::EuropeVolgograd => 'Europe/Volgograd',
            self::EuropeWarsaw => 'Europe/Warsaw',
            self::EuropeZagreb => 'Europe/Zagreb',
            self::EuropeZurich => 'Europe/Zurich',
        };
    }
}
