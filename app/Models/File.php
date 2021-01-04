<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class File extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function getIsValidAttribute(){
        $lines = explode(PHP_EOL, Storage::get($this['path'].'/'.$this['name']));
        $count = 0;
        foreach ($lines as $line) {
            $line = str_replace("\r","",$line);
            $line = str_replace("+","",$line);
            $line = str_replace(" ","",$line);
            if ($line == '' || $line == 'CountryCode,PhoneNumber,IsLocal,Amount') continue;
            $item = explode(',',$line);
            if (sizeof($item) != 4) continue;
            else
                $count++;
        }
        if ($count !== 0)
            return true;
        else{
            $this['status'] = 'INVALID';
            $this->save();
            return false;
        }
    }

    public function processNumbers(){
        if ($this['status'] !== 'PROCESSING') return;
        $lines = explode(PHP_EOL, Storage::get($this['path'].'/'.$this['name']));
        foreach ($lines as $line) {
            $line = str_replace("\r","",$line);
            $line = str_replace("+","",$line);
            $line = str_replace(" ","",$line);
            if ($line == '' || $line == 'CountryCode,PhoneNumber,IsLocal,Amount') continue;
            $item = explode(',',$line);
            if (sizeof($item) != 4) continue;
            FileEntry::create([
                'file_id' => $this['id'],
                'country_id' => Country::where('iso',$item[0])->first()['id'],
                'operator_id' => System::autoDetectOperator($item[1],$item[0],$this['id'])['id'],
                'is_local' => $item[2] != '0',
                'amount' => floatval($item[3]),
                'number' => doubleval($item[1])
            ]);
            sleep(rand(0,2));
        }
        $this['status'] = 'START';
        $this->save();
    }

    public function topups(){
        return $this->hasMany('App\Models\Topup');
    }

    public function numbers(){
        return $this->hasMany('App\Models\FileEntry');
    }

    public function getTotalAmountAttribute(){
        $amount = 0.0;
        foreach($this['numbers'] as $number)
            if ($number['is_local'] && isset($number['operator']))
                $amount += ($number['amount'] / $number['operator']['fx_rate']);
            else
                $amount += $number['amount'];
        return round($amount,2);
    }

}
