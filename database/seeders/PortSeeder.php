<?php
namespace Database\Seeders;

use App\Models\Country;
use App\Models\Port;
use Illuminate\Database\Seeder;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        Port::query()->delete();

        $ports = [
            ['country'=>'Singapore','name'=>'Port of Singapore','city'=>'Singapore','latitude'=>1.2644,'longitude'=>103.8405,'type'=>'Container Port','risk_score'=>10],
            ['country'=>'China','name'=>'Port of Shanghai','city'=>'Shanghai','latitude'=>31.2304,'longitude'=>121.4737,'type'=>'Container Port','risk_score'=>20],
            ['country'=>'Netherlands','name'=>'Port of Rotterdam','city'=>'Rotterdam','latitude'=>51.9244,'longitude'=>4.4777,'type'=>'Container Port','risk_score'=>15],
            ['country'=>'Malaysia','name'=>'Port Klang','city'=>'Klang','latitude'=>3.0000,'longitude'=>101.4000,'type'=>'Container Port','risk_score'=>18],
            ['country'=>'Indonesia','name'=>'Port of Tanjung Priok','city'=>'Jakarta','latitude'=>-6.1049,'longitude'=>106.8860,'type'=>'Container Port','risk_score'=>35],
            ['country'=>'Belgium','name'=>'Port of Antwerp','city'=>'Antwerp','latitude'=>51.2194,'longitude'=>4.4025,'type'=>'Container Port','risk_score'=>14],
            ['country'=>'Germany','name'=>'Port of Hamburg','city'=>'Hamburg','latitude'=>53.5511,'longitude'=>9.9937,'type'=>'Container Port','risk_score'=>13],
            ['country'=>'South Korea','name'=>'Port of Busan','city'=>'Busan','latitude'=>35.1796,'longitude'=>129.0756,'type'=>'Container Port','risk_score'=>11],
            ['country'=>'United Arab Emirates','name'=>'Jebel Ali Port','city'=>'Dubai','latitude'=>25.0657,'longitude'=>55.1713,'type'=>'Container Port','risk_score'=>16],
            ['country'=>'Sri Lanka','name'=>'Port of Colombo','city'=>'Colombo','latitude'=>6.9271,'longitude'=>79.8612,'type'=>'Container Port','risk_score'=>22],
            ['country'=>'Hong Kong','name'=>'Port of Hong Kong','city'=>'Hong Kong','latitude'=>22.3193,'longitude'=>114.1694,'type'=>'Container Port','risk_score'=>12],
            ['country'=>'Taiwan','name'=>'Port of Kaohsiung','city'=>'Kaohsiung','latitude'=>22.6273,'longitude'=>120.3014,'type'=>'Container Port','risk_score'=>12],
            ['country'=>'Vietnam','name'=>'Port of Hai Phong','city'=>'Hai Phong','latitude'=>20.8449,'longitude'=>106.6881,'type'=>'Container Port','risk_score'=>18],
            ['country'=>'Thailand','name'=>'Laem Chabang Port','city'=>'Chonburi','latitude'=>13.0827,'longitude'=>100.8830,'type'=>'Container Port','risk_score'=>19],
            ['country'=>'Japan','name'=>'Port of Yokohama','city'=>'Yokohama','latitude'=>35.4437,'longitude'=>139.6380,'type'=>'Container Port','risk_score'=>9],
            ['country'=>'Philippines','name'=>'Port of Manila','city'=>'Manila','latitude'=>14.5995,'longitude'=>120.9842,'type'=>'Container Port','risk_score'=>21],
            ['country'=>'India','name'=>'Jawaharlal Nehru Port','city'=>'Mumbai','latitude'=>18.9490,'longitude'=>72.9490,'type'=>'Container Port','risk_score'=>23],
            ['country'=>'Pakistan','name'=>'Port of Karachi','city'=>'Karachi','latitude'=>24.8607,'longitude'=>67.0011,'type'=>'Container Port','risk_score'=>27],
            ['country'=>'Saudi Arabia','name'=>'Jeddah Islamic Port','city'=>'Jeddah','latitude'=>21.4858,'longitude'=>39.1925,'type'=>'Container Port','risk_score'=>16],
            ['country'=>'Oman','name'=>'Port of Salalah','city'=>'Salalah','latitude'=>16.9390,'longitude'=>54.0080,'type'=>'Container Port','risk_score'=>15],
            ['country'=>'United States','name'=>'Port of Los Angeles','city'=>'Los Angeles','latitude'=>33.7361,'longitude'=>-118.2631,'type'=>'Container Port','risk_score'=>18],
            ['country'=>'United States','name'=>'Port of Long Beach','city'=>'Long Beach','latitude'=>33.7542,'longitude'=>-118.2167,'type'=>'Container Port','risk_score'=>17],
            ['country'=>'United States','name'=>'Port of New York and New Jersey','city'=>'New York','latitude'=>40.6840,'longitude'=>-74.0419,'type'=>'Container Port','risk_score'=>16],
            ['country'=>'Canada','name'=>'Port of Vancouver','city'=>'Vancouver','latitude'=>49.2965,'longitude'=>-123.1040,'type'=>'Container Port','risk_score'=>14],
            ['country'=>'Brazil','name'=>'Port of Santos','city'=>'Santos','latitude'=>-23.9608,'longitude'=>-46.3336,'type'=>'Container Port','risk_score'=>20],
            ['country'=>'Panama','name'=>'Port of Balboa','city'=>'Balboa','latitude'=>8.9497,'longitude'=>-79.5667,'type'=>'Container Port','risk_score'=>19],
            ['country'=>'Mexico','name'=>'Port of Manzanillo','city'=>'Manzanillo','latitude'=>19.0522,'longitude'=>-104.3158,'type'=>'Container Port','risk_score'=>21],
            ['country'=>'Spain','name'=>'Port of Valencia','city'=>'Valencia','latitude'=>39.4488,'longitude'=>-0.3162,'type'=>'Container Port','risk_score'=>15],
            ['country'=>'France','name'=>'Port of Marseille','city'=>'Marseille','latitude'=>43.2965,'longitude'=>5.3698,'type'=>'Container Port','risk_score'=>16],
            ['country'=>'Italy','name'=>'Port of Genoa','city'=>'Genoa','latitude'=>44.4048,'longitude'=>8.9444,'type'=>'Container Port','risk_score'=>17],
            ['country'=>'Australia','name'=>'Port of Melbourne','city'=>'Melbourne','latitude'=>-37.8136,'longitude'=>144.9631,'type'=>'Container Port','risk_score'=>13],
            ['country'=>'Australia','name'=>'Port Botany','city'=>'Sydney','latitude'=>-33.9667,'longitude'=>151.2000,'type'=>'Container Port','risk_score'=>14],
            ['country'=>'South Africa','name'=>'Port of Durban','city'=>'Durban','latitude'=>-29.8717,'longitude'=>31.0262,'type'=>'Container Port','risk_score'=>24],
            ['country'=>'Egypt','name'=>'Port Said','city'=>'Port Said','latitude'=>31.2653,'longitude'=>32.3019,'type'=>'Container Port','risk_score'=>26],
            ['country'=>'Turkey','name'=>'Port of Ambarli','city'=>'Istanbul','latitude'=>40.9780,'longitude'=>28.6760,'type'=>'Container Port','risk_score'=>18],
            ['country'=>'India','name'=>'Port of Chennai','city'=>'Chennai','latitude'=>13.0827,'longitude'=>80.2707,'type'=>'Container Port','risk_score'=>23],
            ['country'=>'Morocco','name'=>'Tanger Med Port','city'=>'Tangier','latitude'=>35.8888,'longitude'=>-5.5033,'type'=>'Container Port','risk_score'=>17],
            ['country'=>'Nigeria','name'=>'Lagos Port','city'=>'Lagos','latitude'=>6.4550,'longitude'=>3.3841,'type'=>'Container Port','risk_score'=>25],
            ['country'=>'Chile','name'=>'Port of Valparaiso','city'=>'Valparaiso','latitude'=>-33.0472,'longitude'=>-71.6127,'type'=>'Container Port','risk_score'=>18],
            ['country'=>'Peru','name'=>'Port of Callao','city'=>'Callao','latitude'=>-12.0621,'longitude'=>-77.1496,'type'=>'Container Port','risk_score'=>20],
        ];

        foreach ($ports as $item) {
            $country = Country::where('name',$item['country'])->first();
            if(!$country) continue;
            Port::create([
                'country_id'=>$country->id,
                'name'=>$item['name'],
                'city'=>$item['city'],
                'latitude'=>$item['latitude'],
                'longitude'=>$item['longitude'],
                'type'=>$item['type'],
                'risk_score'=>$item['risk_score'],
            ]);
        }
    }
}
