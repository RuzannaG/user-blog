<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    const TYPES = [
        '1'=>'user_profile',
        '2'=>'post'
    ];
    protected $fillable = ['name', 'path', 'url', 'type'];

    public static function upload($file, $type = 'user_profile')
    {
        $originName = $file->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = md5($fileName.'_'.time()).'.'.$extension;

        $file->move(public_path('images'), $fileName);
        return self::create([
            'name' => $originName,
            'path' => '/images/'.$fileName,
            'url' => config('app.url').'/images/'.$fileName,
            'type' => array_flip(self::TYPES)['user_profile'],
        ]);

    }

    public function getTypeAttribute($value){
        $type = self::TYPES[$value];
        return strtoupper(str_replace('_', ' ',$type));
    }
}
