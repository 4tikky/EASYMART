<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndonesiaProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('indonesia_provinces')->insert([
            [
                'id' => 1,
                'code' => 11,
                'name' => 'ACEH',
                'meta' => '{"lat":"4.225728583038235","long":"96.91187408609952"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 2,
                'code' => 12,
                'name' => 'SUMATERA UTARA',
                'meta' => '{"lat":"2.1884379790819697","long":"99.05805717982136"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 3,
                'code' => 13,
                'name' => 'SUMATERA BARAT',
                'meta' => '{"lat":"-0.8485217528678419","long":"100.46541730525067"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 4,
                'code' => 14,
                'name' => 'RIAU',
                'meta' => '{"lat":"0.5087444806663094","long":"101.81497000628609"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 5,
                'code' => 15,
                'name' => 'JAMBI',
                'meta' => '{"lat":"-1.6988005447434649","long":"102.71589131899545"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 6,
                'code' => 16,
                'name' => 'SUMATERA SELATAN',
                'meta' => '{"lat":"-3.2126961773830502","long":"104.17033311473567"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 7,
                'code' => 17,
                'name' => 'BENGKULU',
                'meta' => '{"lat":"-3.556319345904471","long":"102.34247132066047"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 8,
                'code' => 18,
                'name' => 'LAMPUNG',
                'meta' => '{"lat":"-4.917314824098222","long":"105.02166076303229"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 9,
                'code' => 19,
                'name' => 'KEPULAUAN BANGKA BELITUNG',
                'meta' => '{"lat":"-2.449935699425567","long":"106.55613967526148"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 10,
                'code' => 21,
                'name' => 'KEPULAUAN RIAU',
                'meta' => '{"lat":"1.4810032134282223","long":"105.40492588052649"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 11,
                'code' => 31,
                'name' => 'DAERAH KHUSUS IBUKOTA JAKARTA',
                'meta' => '{"lat":"-6.199048542607956","long":"106.83437824682376"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 12,
                'code' => 32,
                'name' => 'JAWA BARAT',
                'meta' => '{"lat":"-6.920631357785788","long":"107.60331918557674"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 13,
                'code' => 33,
                'name' => 'JAWA TENGAH',
                'meta' => '{"lat":"-7.259392265876053","long":"110.2014881759208"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 14,
                'code' => 34,
                'name' => 'DAERAH ISTIMEWA YOGYAKARTA',
                'meta' => '{"lat":"-7.894921269797175","long":"110.44558810593688"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 15,
                'code' => 35,
                'name' => 'JAWA TIMUR',
                'meta' => '{"lat":"-7.719383482967257","long":"112.73244037323282"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 16,
                'code' => 36,
                'name' => 'BANTEN',
                'meta' => '{"lat":"-6.456132803995097","long":"106.10895696008346"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 17,
                'code' => 51,
                'name' => 'BALI',
                'meta' => '{"lat":"-8.369769699656143","long":"115.13167541864175"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 18,
                'code' => 52,
                'name' => 'NUSA TENGGARA BARAT',
                'meta' => '{"lat":"-8.606609171075474","long":"117.50762093778069"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 19,
                'code' => 53,
                'name' => 'NUSA TENGGARA TIMUR',
                'meta' => '{"lat":"-9.260420975885916","long":"122.1818295163483"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 20,
                'code' => 61,
                'name' => 'KALIMANTAN BARAT',
                'meta' => '{"lat":"-0.086523724678437","long":"111.12076049059415"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 21,
                'code' => 62,
                'name' => 'KALIMANTAN TENGAH',
                'meta' => '{"lat":"-1.6061537640941033","long":"113.41627458610972"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 22,
                'code' => 63,
                'name' => 'KALIMANTAN SELATAN',
                'meta' => '{"lat":"-3.0020676284315178","long":"115.43961754350589"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 23,
                'code' => 64,
                'name' => 'KALIMANTAN TIMUR',
                'meta' => '{"lat":"0.4546885880388276","long":"116.45094318132922"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 24,
                'code' => 65,
                'name' => 'KALIMANTAN UTARA',
                'meta' => '{"lat":"2.915025102027767","long":"116.24567929615681"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 25,
                'code' => 71,
                'name' => 'SULAWESI UTARA',
                'meta' => '{"lat":"1.2611200722402653","long":"124.52273057269113"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 26,
                'code' => 72,
                'name' => 'SULAWESI TENGAH',
                'meta' => '{"lat":"-1.0179487916987044","long":"121.20690427525082"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 27,
                'code' => 73,
                'name' => 'SULAWESI SELATAN',
                'meta' => '{"lat":"-3.734059470692148","long":"120.16108812544049"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 28,
                'code' => 74,
                'name' => 'SULAWESI TENGGARA',
                'meta' => '{"lat":"-4.1364611491307475","long":"122.07459069007979"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 29,
                'code' => 75,
                'name' => 'GORONTALO',
                'meta' => '{"lat":"0.6863018602241926","long":"122.37570455293411"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 30,
                'code' => 76,
                'name' => 'SULAWESI BARAT',
                'meta' => '{"lat":"-2.4655741522297205","long":"119.34743476950884"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 31,
                'code' => 81,
                'name' => 'MALUKU',
                'meta' => '{"lat":"-4.738146361226596","long":"129.84017376291038"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 32,
                'code' => 82,
                'name' => 'MALUKU UTARA',
                'meta' => '{"lat":"0.21161515429599007","long":"127.54213573832187"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 33,
                'code' => 91,
                'name' => 'PAPUA',
                'meta' => '{"lat":"-2.6178780251772356","long":"138.5321560216282"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 34,
                'code' => 92,
                'name' => 'PAPUA BARAT',
                'meta' => '{"lat":"-2.6540391778109638","long":"133.64947782326237"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 35,
                'code' => 93,
                'name' => 'PAPUA SELATAN',
                'meta' => '{"lat":"-6.680063683843342","long":"139.54696286744857"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 36,
                'code' => 94,
                'name' => 'PAPUA TENGAH',
                'meta' => '{"lat":"-3.90333032589129","long":"136.64416653892764"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 37,
                'code' => 95,
                'name' => 'PAPUA PEGUNUNGAN',
                'meta' => '{"lat":"-4.269444191165071","long":"139.49860571993986"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ],
            [
                'id' => 38,
                'code' => 96,
                'name' => 'PAPUA BARAT DAYA',
                'meta' => '{"lat":"-1.1238365035890352","long":"131.95465346505267"}',
                'created_at' => '2025-12-11 02:46:04',
                'updated_at' => '2025-12-11 02:46:04'
            ]
        ]);
    }
}
