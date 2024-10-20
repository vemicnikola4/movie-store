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

    public function createMedia( string $filePath,$imageContent) : Media
     {
            $extention = substr($filePath,strpos($filePath,'.')+1 );

            $imageExists = Media::where('path',$filePath)->first();
          
            if (  !$imageExists ){
                try {
                    // Create a new movie entry
                    Storage::disk('public')->put($filePath, $imageContent);
                    
                    $media = new Media;
                    $media->path = $filePath;
                    $media->extention = $extention;
                    $media->alt = 'image';
                    $media->save();
                    return $media;
                } catch (QueryException $e) {
                    // Handle database-related exceptions
                    throw new MediaException('Database error while creating Media: ' . $e->getMessage());
                } catch (\Exception $e) {
                    // Handle any other exceptions
                    throw new MediaException('An unexpected error occurred: ' . $e->getMessage());
                } 
            }
            return $imageExists;

    }
}