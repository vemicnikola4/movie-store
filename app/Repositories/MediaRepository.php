<?php
namespace App\Repositories;

use App\Interfaces\MediaRepositoryInterface;
use App\Models\Media;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;


class MediaRepository implements MediaRepositoryInterface{

    public function __construct(
        protected Media $model
    ){}

    public function getOne($id) : Media 
    {
        return Media::find($id);
    }

    public function getOneWithPath($path) : ?Media 
    {
        return Media::where('path',$path)->first();
    }


    public function create( array $data) : Media
    {
        try {
            $media = new Media;
            $media->path = $data['path'];
            $media->extention = $data['extention'];
            $media->alt = $data['alt'];
            $media->save();
            return $media;
            
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }
}