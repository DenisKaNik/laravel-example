<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Anketa
 * @package App
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $education
 * @property string $type
 * @property string $ip
 * @property string $get_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Anketa whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Anketa whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Anketa whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Anketa wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Anketa whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Anketa whereEducation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Anketa whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Anketa whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Anketa whereGetUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Anketa whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Anketa whereUpdatedAt($value)
 */
class Anketa extends Model
{
    /**
     * @var string
     */
    protected $table = 'anketa';

    /**
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'education', 'type', 'ip', 'get_url'];

    public static function boot()
    {
        static::creating(function($anketa) {
            $anketa->ip = $_SERVER['REMOTE_ADDR'];
            $anketa->get_url = self::formatted(\Request::getRequestUri());
        });

        parent::boot();
    }

    protected static function formatted($value)
    {
        $value = strip_tags(urldecode($value));

        $value = str_replace([
            'alert',
            'php',
            'script',
            'javascript',
            'java',
            'select',
            'insert',
            'update',
            'delete',
            'union',
        ], '', $value);

        $value = preg_replace('#([^a-zA-Z=\?\-&]+)#', '', $value);

        return $value;
    }
}
