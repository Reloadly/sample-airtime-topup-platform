<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = array(
            array('name' =>'US dollar', 'abbr' =>'USD', 'symbol' =>'$'),
            array('name' =>'Canadian dollars', 'abbr' =>'CAD', 'symbol' =>'$'),
            array('name' =>'Pounds sterling', 'abbr' =>'GBP', 'symbol' =>'£'),
            array('name' =>'Euro', 'abbr' =>'EUR', 'symbol' =>'€'),
            array('name' =>'Australian dollars', 'abbr' =>'AUD', 'symbol' =>'$'),
            array('name' =>'Bangladeshi taka', 'abbr' =>'BDT', 'symbol' =>'৳'),
            array('name' =>'Brazilian real', 'abbr' =>'BRL', 'symbol' =>'R$'),
            array('name' =>'Bulgarian lev', 'abbr' =>'BGN', 'symbol' =>'лв'),
            array('name' =>'Chilean peso', 'abbr' =>'CLP', 'symbol' =>'$'),
            array('name' =>'Chinese yuan', 'abbr' =>'CNY', 'symbol' =>'¥ /元'),
            array('name' =>'Colombian peso', 'abbr' =>'COP', 'symbol' =>'$'),
            array('name' =>'Croatian Kuna', 'abbr' =>'HRK', 'symbol' =>'kn'),
            array('name' =>'Czech koruna', 'abbr' =>'CZK', 'symbol' =>'Kč'),
            array('name' =>'Danish krone', 'abbr' =>'DKK', 'symbol' =>'kr'),
            array('name' =>'Emirati dirham', 'abbr' =>'AED', 'symbol' =>'د.إ'),
            array('name' =>'Georgian lari', 'abbr' =>'GEL', 'symbol' =>'₾'),
            array('name' =>'Hong Kong dollar', 'abbr' =>'HKD', 'symbol' =>'$ / HK$ / “元”'),
            array('name' =>'Hungarian forint', 'abbr' =>'HUF', 'symbol' =>'ft'),
            array('name' =>'Indian rupee', 'abbr' =>'INR', 'symbol' =>'₹'),
            array('name' =>'Indonesian rupiah', 'abbr' =>'IDR', 'symbol' =>'Rp'),
            array('name' =>'Israeli shekel', 'abbr' =>'ILS', 'symbol' =>'₪'),
            array('name' =>'Japanese yen', 'abbr' =>'JPY', 'symbol' =>'¥'),
            array('name' =>'Kenyan shilling', 'abbr' =>'KES', 'symbol' =>'Ksh'),
            array('name' =>'Malaysian ringgit', 'abbr' =>'MYR', 'symbol' =>'RM'),
            array('name' =>'Mexican peso', 'abbr' =>'MXN', 'symbol' =>'$'),
            array('name' =>'Moroccan dirham', 'abbr' =>'MAD', 'symbol' =>'.د.م'),
            array('name' =>'New Zealand dollar', 'abbr' =>'NZD', 'symbol' =>'$'),
            array('name' =>'Nigerian naira', 'abbr' =>'NGN', 'symbol' =>'₦'),
            array('name' =>'Norwegian krone', 'abbr' =>'NOK', 'symbol' =>'kr'),
            array('name' =>'Pakistani rupee', 'abbr' =>'PKR', 'symbol' =>'Rs'),
            array('name' =>'Peruvian sol', 'abbr' =>'PEN', 'symbol' =>'S/.'),
            array('name' =>'Philippine peso', 'abbr' =>'PHP', 'symbol' =>'₱'),
            array('name' =>'Polish zloty', 'abbr' =>'PLN', 'symbol' =>'zł'),
            array('name' =>'Romanian leu', 'abbr' =>'RON', 'symbol' =>'lei'),
            array('name' =>'Russian ruble', 'abbr' =>'RUB', 'symbol' =>'₽'),
            array('name' =>'Singapore dollar', 'abbr' =>'SGD', 'symbol' =>'$'),
            array('name' =>'South Korean won', 'abbr' =>'KRW', 'symbol' =>'₩'),
            array('name' =>'Sri Lankan rupee', 'abbr' =>'LKR', 'symbol' =>'Rs'),
            array('name' =>'Swedish krona', 'abbr' =>'SEK', 'symbol' =>'kr'),
            array('name' =>'Swiss franc', 'abbr' =>'CHF', 'symbol' =>'CHf'),
            array('name' =>'Thai baht', 'abbr' =>'THB', 'symbol' =>'฿'),
            array('name' =>'Turkish lira', 'abbr' =>'TRY', 'symbol' =>'₺'),
            array('name' =>'Ukrainian hryvna', 'abbr' =>'UAH', 'symbol' =>'₴'),
            array('name' =>'Vietnamese dong', 'abbr' =>'VND', 'symbol' =>'₫')
        );
        foreach($currencies as $currency){

            \App\Models\Currency::updateOrCreate(['name' => $currency['name'], 'abbr' => $currency['abbr'], 'symbol' => $currency['symbol']]);
        }
    }
}
