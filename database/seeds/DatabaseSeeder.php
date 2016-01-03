<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
//use Artisan;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
	    Artisan::call('migrate:reset');
        Artisan::call('migrate');

		Model::unguard();

		// $this->call('UserTableSeeder');
        DB::table('patrons')->insert([
            'name' => 'Moi Nguyen',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/v/t1.0-1/p160x160/10501956_10155702608375243_7881959238130733816_n.jpg?oh=689930714c9f836e8c1cdb9b65571cb3&oe=570A2124&__gda__=1459580436_473455107354ade74fc4dc0add62d0c1',
            'address' => '22 York st',
            'suburb' => 'Indooroopilly',
            'postcode' => '4068'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Nhi Ho',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xta1/v/t1.0-1/p160x160/10846214_10152953124387269_8694827571637277011_n.jpg?oh=039d4db0bdeeb380a44d7bbef8f598b9&oe=570A468D&__gda__=1460226290_5f2dd264c6dc2e8390aad64ca203cbd7',
            'address' => '22 York st',
            'suburb' => 'Indooroopilly',
            'postcode' => '4068'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Joel Tan',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/v/t1.0-1/p160x160/1908434_10204229239153826_2903751609215414357_n.jpg?oh=0aa75177bcf0a86f3052b7837e95a8d7&oe=571E0D65&__gda__=1461557289_dcdb61c8a32a53e7b0ff606f98a7d0a3',
            'address' => '27 Jerrold St',
            'suburb' => 'Sherwood',
            'postcode' => '4075'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Leroy Yeow',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpa1/v/t1.0-1/c0.27.160.160/p160x160/12188917_10207733731959646_301122212905587445_n.jpg?oh=3f5a597b43f8ae2a68d5295f9dd8aaa6&oe=57058389&__gda__=1460150347_9fbfc600f074690099898f12d05a8013',
            'address' => '23 Fifth Ave',
            'suburb' => 'St Lucia',
            'postcode' => '4067'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Bryan Chow',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xta1/v/t1.0-1/p160x160/10689687_875858599100550_3878958325921098127_n.jpg?oh=a1754460acc9fa36bb1ee0bfc5540a43&oe=56D39471&__gda__=1460286047_182133ef0fb6b7c56b880872eeefbb0f',
            'address' => '23 Fifth Ave',
            'suburb' => 'St Lucia',
            'postcode' => '4067'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Jessie Ungry',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/v/t1.0-1/p160x160/12039446_1503907183260602_8189802186644674647_n.jpg?oh=38d33809bae92850f22ddf1725dc9bf1&oe=570409AB&__gda__=1464359399_9c8ca9c2c41154dddd39a2362684cf50',
            'address' => '23 Fifth Ave',
            'suburb' => 'St Lucia',
            'postcode' => '4067'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Deryk Yeo',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xap1/v/t1.0-1/p160x160/1462926_10202791254245455_354767871_n.jpg?oh=a14c19a17d9423fef5c3f5317108823f&oe=56FBDCBB&__gda__=1460166811_33188d45e8572b091395d2cd5dc3c3ba',
            'address' => '23 Fifth Ave',
            'suburb' => 'St Lucia',
            'postcode' => '4067'
        ]);

        DB::table('patrons')->insert([
            'name' => 'Shon Yin Hoh',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/v/t1.0-1/c66.66.828.828/s160x160/255418_10151182083434939_474773390_n.jpg?oh=6caa4c6bb641663f2f0668254075857e&oe=5721DF55&__gda__=1461101302_d61691940cd84925593d9472e31877b3',
            'address' => '122 Macquarie St',
            'suburb' => 'St lucia',
            'postcode' => '4067'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Audrey Lim',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xtl1/v/t1.0-1/p160x160/11665669_383837845141312_8861064392568128999_n.jpg?oh=6429a5e48b226e49ff8ffe070813d675&oe=56FF9218&__gda__=1460984057_13530373af549655f8b9918f17e2d24e',
            'address' => '8 Rock St',
            'suburb' => 'St Lucia',
            'postcode' => '4067'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Adeline Choo',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/c0.0.160.160/p160x160/1924462_10151920821771659_732609988_n.jpg?oh=336161efac57fd69796f74e29bc289b3&oe=57127554&__gda__=1460716807_8ab839c755b3465eda35e6a61d258a60',
            'address' => '159 Logan Rd',
            'suburb' => 'Woolloongabba',
            'postcode' => '4102'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Adrian Yap',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xtl1/v/t1.0-1/p160x160/10407814_10153093286198678_4593643411788578399_n.jpg?oh=1b565a55c94ef675f80805778a59c02b&oe=5715DCD6&__gda__=1459825001_1a6019281fc9165a313b73937a875f90',
            'address' => '8 Norfolk street',
            'suburb' => 'Parkinson',
            'postcode' => '4115'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Alex Mimery',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-frc3/v/t1.0-1/p160x160/10805749_10152556395808553_8639857538740387039_n.jpg?oh=917a66054ec4554e72ad6e6913a11452&oe=571D2D80&__gda__=1460909866_04f30268cebc4342138fbd2640708275',
            'address' => '64 Belgrave Rd',
            'suburb' => 'Indooroopilly',
            'postcode' => '4068'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Ying Ying Lee',
            'picurl' => 'https://scontent-lax3-1.xx.fbcdn.net/hprofile-xla1/v/l/t1.0-1/p160x160/11129633_10205407863932224_5209883268163957724_n.jpg?oh=a3d5bf329b925704f4a246eeaf766a52&oe=56FBB21C',
            'address' => '424 moggill road',
            'suburb' => 'Indooroopilly',
            'postcode' => '4068'
        ]);

        DB::table('patrons')->insert([
            'name' => 'Aik Lim Tan',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpa1/v/t1.0-1/c0.0.160.160/p160x160/1505062_10153655918455061_562480793_n.jpg?oh=e7733a6e6d9c82a4733b4d27e870a11d&oe=56FCE702&__gda__=1460541249_e4c472d79e9a00a768d39a9b40d213a1',
            'address' => '92 Station Rd',
            'suburb' => 'Indooroopilly',
            'postcode' => '4068'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Zhuan Khai Lim',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpa1/v/t1.0-1/c0.0.160.160/p160x160/1375790_10201413284068565_786657117_n.jpg?oh=4e2fb36dc61ac858ed0a5f660c902c2a&oe=57464F21&__gda__=1460542306_4b870c8ab4b0653067edb0d154b5ccd6',
            'address' => '92 Station Rd',
            'suburb' => 'Indooroopilly',
            'postcode' => '4068'
        ]);

        DB::table('patrons')->insert([
            'name' => 'QianZi Lim',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/v/t1.0-1/p160x160/11096666_10153082970151609_5689006208151523647_n.jpg?oh=b023f2b4bdd0d4e7a3ddc113d776e848&oe=57051C27&__gda__=1459998231_2b5a3feac272ae4f0d7bba1287ddb91f',
            'address' => '44 Station Rd',
            'suburb' => 'Indooroopilly',
            'postcode' => '4068'
        ]);

        DB::table('patrons')->insert([
            'name' => 'Madeleine Mandy',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xap1/v/t1.0-1/p160x160/12299296_1139231862768608_5359698843562951528_n.jpg?oh=ef3390c4cd5cbb705bf21bf9f03413d1&oe=5749AFCE&__gda__=1460507697_ab985512085e90b1e0d5dc655958e008',
            'address' => '56 Macquarie St',
            'suburb' => 'St Lucia',
            'postcode' => '4067'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Crystal Loke',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/v/t1.0-1/p160x160/11205143_958895027455522_596576943798236024_n.jpg?oh=248d0b61c9989803cea138dc526ba5d2&oe=5705810B&__gda__=1460728717_db5dbbb3a3327e4a5659533277f014a2',
            'address' => '20 Holland Street',
            'suburb' => 'Toowong',
            'postcode' => '4066'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Liang Lee',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpt1/v/t1.0-1/p160x160/11701133_135900410088912_1582954001155020929_n.jpg?oh=9d098d026396109d53a596804d5cbbd3&oe=56FBE46B&__gda__=1460033814_d030482f74ebbc482cfe52d50b0dabfd',
            'address' => '27 Harrys Rd',
            'suburb' => 'Taringa',
            'postcode' => '4068'
        ]);

        DB::table('patrons')->insert([
            'name' => 'En Ying Cheah',
            'picurl' => 'https://scontent-lax3-1.xx.fbcdn.net/hprofile-xfp1/v/l/t1.0-1/p160x160/1509762_10205545588213574_6117977136104680882_n.jpg?oh=31cd82de9af0ee345f1e495ca50eaab5&oe=57037CA7',
            'address' => '247 Carmody Rd',
            'suburb' => 'St Lucia',
            'postcode' => '4067'
        ]);

        DB::table('patrons')->insert([
            'name' => 'Ivy Kong',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/v/t1.0-1/p160x160/11115603_956047811092469_1854816305722121041_n.jpg?oh=6661337efbd280d4a455ff9db0227dd9&oe=571025E3&__gda__=1461376618_2352ffb8e0b523b3bfa1cc43c5d6d0a2',
            'address' => '22 Warren St',
            'suburb' => 'St Lucia',
            'postcode' => '4067'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Krystel Fyffe',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xtf1/v/t1.0-1/p160x160/11015205_10152865048343461_7722655021838660565_n.jpg?oh=f052b97604695c7e0719ae52dc57f928&oe=5709E006&__gda__=1464314512_85afcdb56b62ba23de17de108738ce7d',
            'address' => '31 Warren street',
            'suburb' => 'St Lucia',
            'postcode' => '4067'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Sarah Yee',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xap1/v/t1.0-1/p160x160/988232_10152943209310492_106489640_n.jpg?oh=a8c03c3b364111c1b546fa87ac90a011&oe=570F8360&__gda__=1460838338_65bdbb5a5924866f6935232d4ff56753',
            'address' => '31 Warren street',
            'suburb' => 'St Lucia',
            'postcode' => '4067'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Ryan Ng',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-frc3/v/t1.0-1/c66.66.828.828/s160x160/1175055_10151877982662216_1439959143_n.jpg?oh=e1e6057c029c6f65bb9f169e1ce41c2d&oe=571C077F&__gda__=1460996846_1dacb0c9d3551916f25d3586250fb42f',
            'address' => '151 annerley road',
            'suburb' => 'Dutton Park',
            'postcode' => '4102'
        ]);

        DB::table('events')->insert([
            'name' => 'Life Group',
            'datetime' => '2016-01-01 06:16:21',
        ]);
        DB::table('events')->insert([
            'name' => 'Church Service',
            'datetime' => '2016-01-01 06:16:21',
        ]);
        DB::table('events')->insert([
            'name' => 'Special Event',
            'datetime' => '2016-01-01 06:16:21',
        ]);

        $patronsData = DB::table('patrons')->get();
        $eventsData = DB::table('events')->get();

        foreach ($eventsData as $eventData){
            foreach ($patronsData as $patronData){
                DB::table('event_patron')->insert(['event_id' => $eventData->id,'patron_id' => $patronData->id, 
                    'carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1']);
            }
        }
        
        DB::table('nearby_sets')->insert(array(
            ['nearbyset' => '1,2'],
            ['nearbyset' => '4,5,6,7'],
            ['nearbyset' => '14,15'],
            ['nearbyset' => '22,23']
        ));
	}

}
