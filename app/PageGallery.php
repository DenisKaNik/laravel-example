<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PageGallery
 * @package App
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $file
 * @method static \Illuminate\Database\Query\Builder|\App\PageGallery whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageGallery wherePageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageGallery whereFile($value)
 */

class PageGallery extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'page_gallery';

    /**
     * @var array
     */
    public $fillable = ['page_id', 'file'];
}
