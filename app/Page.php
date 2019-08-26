<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as ImageManager;
use Validator;

/**
 * Class Page
 * @package App
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereId($value)
 */

class Page extends Model
{
    const
        GALLERY_PREVIEW_UPLOAD_DIR = 'uploads/pages/gallery/previews/',
        GALLERY_UPLOAD_DIR = 'uploads/pages/gallery/',
        THUMB_WIDTH = 730,
        THUMB_HEIGHT = 476;

    public function gallery()
    {
        return $this
            ->hasMany('App\PageGallery', 'page_id', 'id')
            ->orderBy('id');
    }

    public function getGallery()
    {
        if (!$this->gallery->count()) {
            return false;
        }

        return $this->gallery->map(function($image){
            return [
                'id' => $image->id,
                'file' => static::previewGalleryPicture($image->file),
                'preview' => static::previewGalleryPicture($image->file, true),
            ];
        });
    }

    private static function previewGalleryPicture($file, $preview = false)
    {
        return asset(($preview ? static::GALLERY_PREVIEW_UPLOAD_DIR : static::GALLERY_UPLOAD_DIR) . $file);
    }

    public function setPageGalleryAttribute()
    {
        if (!$this->id) {
            $this->save();
        }

        if (\Input::has('delete_gallery_item')) {
            collect(\Input::get('delete_gallery_item'))->map(function($v, $k){
                $image = PageGallery::whereId($k)->first();

                \File::delete(
                    self::GALLERY_PREVIEW_UPLOAD_DIR.$image->file,
                    self::GALLERY_UPLOAD_DIR.$image->file
                );

                $image->delete();
            });
        }

        if (\Input::hasFile('gallery')) {
            (collect(\Input::file('gallery')))->map(function($file){

                // Validate upload file
                $validator = Validator::make(['file' => $file], [
                    'file' => 'mimes:jpg,jpeg,png|max:4096',
                ]);

                if ($validator->fails()) {
                    throw new \ErrorException('Error upload file.');
                }
                else {
                    if (!$file->getError()) {
                        File::makeDirectory(self::GALLERY_PREVIEW_UPLOAD_DIR, $mode = 0777, true, true);

                        $file_name = uniqid().'.'.$file->getClientOriginalExtension();

                        ImageManager::make($file->getRealPath())
                            ->resize(self::THUMB_WIDTH, self::THUMB_HEIGHT)
                            ->save(self::GALLERY_PREVIEW_UPLOAD_DIR.$file_name);

                        $file->move(self::GALLERY_UPLOAD_DIR, $file_name);

                        PageGallery::insert([
                            'page_id' => $this->id,
                            'file' => $file_name,
                        ]);
                    }
                }
            });
        }
    }
}
