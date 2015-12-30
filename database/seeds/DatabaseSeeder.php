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
            'name' => 'Bryan Chow',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xta1/v/t1.0-1/p160x160/10689687_875858599100550_3878958325921098127_n.jpg?oh=a1754460acc9fa36bb1ee0bfc5540a43&oe=56D39471&__gda__=1460286047_182133ef0fb6b7c56b880872eeefbb0f',
            'address' => '15 Bayliss St',
            'suburb' => 'Auchenflower',
            'nearby' => 'Adrian Yap'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Moi Nguyen',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/v/t1.0-1/p160x160/10501956_10155702608375243_7881959238130733816_n.jpg?oh=689930714c9f836e8c1cdb9b65571cb3&oe=570A2124&__gda__=1459580436_473455107354ade74fc4dc0add62d0c1',
            'address' => '1 McCaul St',
            'suburb' => 'Taringa',
            'nearby' => 'Nhi Ho'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Joel Tan',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/v/t1.0-1/p160x160/1908434_10204229239153826_2903751609215414357_n.jpg?oh=0aa75177bcf0a86f3052b7837e95a8d7&oe=571E0D65&__gda__=1461557289_dcdb61c8a32a53e7b0ff606f98a7d0a3',
            'address' => '15 Johnston St',
            'suburb' => 'Oxley',
            'nearby' => 'null'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Leroy Yeow',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpa1/v/t1.0-1/c0.27.160.160/p160x160/12188917_10207733731959646_301122212905587445_n.jpg?oh=3f5a597b43f8ae2a68d5295f9dd8aaa6&oe=57058389&__gda__=1460150347_9fbfc600f074690099898f12d05a8013',
            'address' => '15 Bayliss St',
            'suburb' => 'Auchenflower',
            'nearby' => 'Adrian Yap'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Nhi Ho',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xta1/v/t1.0-1/p160x160/10846214_10152953124387269_8694827571637277011_n.jpg?oh=039d4db0bdeeb380a44d7bbef8f598b9&oe=570A468D&__gda__=1460226290_5f2dd264c6dc2e8390aad64ca203cbd7',
            'address' => '1 McCaul St',
            'suburb' => 'Taringa',
            'nearby' => 'Moi Nguyen'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Shon Yin Hoh',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/v/t1.0-1/c66.66.828.828/s160x160/255418_10151182083434939_474773390_n.jpg?oh=6caa4c6bb641663f2f0668254075857e&oe=5721DF55&__gda__=1461101302_d61691940cd84925593d9472e31877b3',
            'address' => '15 McQuarie St',
            'suburb' => 'Stlucia',
            'nearby' => 'null'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Audrey Lim',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xtl1/v/t1.0-1/p160x160/11665669_383837845141312_8861064392568128999_n.jpg?oh=6429a5e48b226e49ff8ffe070813d675&oe=56FF9218&__gda__=1460984057_13530373af549655f8b9918f17e2d24e',
            'address' => '15 Random St',
            'suburb' => 'Stlucia',
            'nearby' => 'null'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Adeline Choo',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/c0.0.160.160/p160x160/1924462_10151920821771659_732609988_n.jpg?oh=336161efac57fd69796f74e29bc289b3&oe=57127554&__gda__=1460716807_8ab839c755b3465eda35e6a61d258a60',
            'address' => '15 Logan Rd',
            'suburb' => 'Woolongabba',
            'nearby' => 'null'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Adrian Yap',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xtl1/v/t1.0-1/p160x160/10407814_10153093286198678_4593643411788578399_n.jpg?oh=1b565a55c94ef675f80805778a59c02b&oe=5715DCD6&__gda__=1459825001_1a6019281fc9165a313b73937a875f90',
            'address' => '15 Bayliss St',
            'suburb' => 'Auchenflower',
            'nearby' => 'Bryan Chow'
        ]);
        DB::table('patrons')->insert([
            'name' => 'Alex Mimery',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-frc3/v/t1.0-1/p160x160/10805749_10152556395808553_8639857538740387039_n.jpg?oh=917a66054ec4554e72ad6e6913a11452&oe=571D2D80&__gda__=1460909866_04f30268cebc4342138fbd2640708275',
            'address' => '15 Some Rd',
            'suburb' => 'Indooroopilly',
            'nearby' => 'null'
        ]);

        DB::table('events')->insert([
            'name' => 'Church Service Unidus, Willawong',
            'datetime' => '2016-01-01 06:16:21',
        ]);
        DB::table('events')->insert([
            'name' => 'Church-wide Prayer Unidus, Willawong',
            'datetime' => '2016-01-01 06:16:21',
        ]);
        DB::table('events')->insert([
            'name' => 'Christmas Celebration, near Roma',
            'datetime' => '2016-01-01 06:16:21',
        ]);

        DB::table('event_patron')->insert(array(
        	['event_id' => '1','patron_id' => '1','carthere' => 'any','carback' => 'adeline','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '1','patron_id' => '2','carthere' => 'driving','carback' => 'driving','leavingtime' => 'na', 'softdelete' => '1'],
            ['event_id' => '1','patron_id' => '3','carthere' => 'driving','carback' => 'driving','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '1','patron_id' => '4','carthere' => 'any','carback' => 'staying','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '1','patron_id' => '5','carthere' => 'adeline','carback' => 'moi','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '1','patron_id' => '6','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '1','patron_id' => '7','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '1','patron_id' => '8','carthere' => 'driving','carback' => 'driving','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '1','patron_id' => '9','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
            ['event_id' => '1','patron_id' => '10','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '2','patron_id' => '1','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '2','patron_id' => '2','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '2','patron_id' => '3','carthere' => 'driving','carback' => 'driving','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '2','patron_id' => '4','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
            ['event_id' => '2','patron_id' => '5','carthere' => 'adeline','carback' => 'moi','leavingtime' => 'na', 'softdelete' => '1'],
            ['event_id' => '2','patron_id' => '6','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
            ['event_id' => '2','patron_id' => '7','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
            ['event_id' => '2','patron_id' => '8','carthere' => 'driving','carback' => 'driving','leavingtime' => 'na', 'softdelete' => '1'],
            ['event_id' => '2','patron_id' => '9','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
            ['event_id' => '2','patron_id' => '10','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '3','patron_id' => '1','carthere' => 'driving','carback' => 'driving','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '3','patron_id' => '2','carthere' => 'any','carback' => 'bryan','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '3','patron_id' => '3','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '3','patron_id' => '4','carthere' => 'driving','carback' => 'driving','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '3','patron_id' => '5','carthere' => 'leroy','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '3','patron_id' => '6','carthere' => 'any','carback' => 'any','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '3','patron_id' => '7','carthere' => 'adeline','carback' => 'adeline','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '3','patron_id' => '8','carthere' => 'driving','carback' => 'driving','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '3','patron_id' => '9','carthere' => 'any','carback' => 'adeline','leavingtime' => 'na', 'softdelete' => '1'],
        	['event_id' => '3','patron_id' => '10','carthere' => 'none','carback' => 'none','leavingtime' => 'na', 'softdelete' => '1'],
        ));
	}

}
