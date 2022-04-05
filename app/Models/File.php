<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class File extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function getIsValidAttribute(): bool
    {
        $lines = explode(PHP_EOL, Storage::get($this['path'].'/'.$this['name']));
        $count = 0;
        foreach ($lines as $line) {
            $line = str_replace(array("\r", "+", " "), "", $line);
            if ($line === '' || $line === 'CountryCode,PhoneNumber,IsLocal,Amount') continue;
            $item = explode(',',$line);
            if (count($item) !== 4) {
                continue;
            }

            $count++;
        }
        if ($count !== 0) {
            return true;
        }

        $this['status'] = 'INVALID';
        $this->save();
        return false;
    }

    /**
     * @throws \Exception
     */
    public function processNumbers(): void
    {
        if ($this['status'] !== 'PROCESSING') return;
        $lines = explode(PHP_EOL, Storage::get($this['path'].'/'.$this['name']));
        foreach ($lines as $line) {
            $line = str_replace(array("\r", "+", " "), "", $line);
            if ($line === '' || $line === 'CountryCode,PhoneNumber,IsLocal,Amount') continue;
            $item = explode(',',$line);
            if (count($item) !== 4) continue;
            $operator = System::autoDetectOperator($item[1],$item[0],$this['id']);
            FileEntry::create([
                'file_id' => $this['id'],
                'country_id' => Country::where('iso',$item[0])->first()['id'],
                'operator_id' => $operator ? $operator['id'] : 0,
                'is_local' => $item[2] !== '0',
                'amount' => (float)$item[3],
                'number' => (float)$item[1]
            ]);
            sleep(random_int(0,2));
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
