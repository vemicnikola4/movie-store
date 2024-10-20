<?php
namespace App\Services;

use App\Services\ApiService;
use App\Interfaces\MediaRepositoryInterface;
use App\Repositories\MediaRepository;
use App\Models\Media;


class MediaService{

    protected $apiService;
    protected $mediaRepository;

    public function __construct(ApiService $apiService, MediaRepositoryInterface  $mediaRepository)
    {
        $this->apiService = $apiService;
        $this->mediaRepository = $mediaRepository;
    }
    
    public function downloadImage(?string $imagePath) : Media{

        if ( $imagePath !== null ){
            $imageContent = $this->apiService->fetchImage($imagePath);

            $filePath = 'images/' . basename($imagePath);

            return $this->mediaRepository->createMedia($filePath, $imageContent);
            

            
            
        }else{
            $imageContent = null;
            $filePath = 'images/blankPic.png';
            return $this->mediaRepository->createMedia($filePath, $imageContent);

            // $defaultProfileImage = Media::where('path','images/blankPic.png')->first();;
            // if( $defaultProfileImage !== null ){
            //     return $defaultProfileImage->id;
            // }else{
            //     $extention = 'png';
            //     $media = new Media;
            //     $media->path = 'images/blankPic.png';
            //     $media->extention = $extention;
            //     $media->alt = 'image';
            //     $media->save();
            //     return $media->id;
            // }
        }
        
    }
    



}