<?php
namespace App\Services;

use App\Services\ApiService;
use App\Interfaces\MediaRepositoryInterface;
use App\Repositories\MediaRepository;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;



class MediaService{

    protected $apiService;
    protected $mediaRepository;

    public function __construct(ApiService $apiService, MediaRepositoryInterface  $mediaRepository)
    {
        $this->apiService = $apiService;
        $this->mediaRepository = $mediaRepository;
    }
    
    public function downloadImage(?string $imagePath) : Media
    {

        if ( $imagePath !== null ){

            $imageContent = $this->apiService->fetchImage($imagePath);

            $filePath = 'images/' . basename($imagePath);


            return $this->insertOneMedia($filePath, $imageContent);
            

            
            
        }else{
            $imageContent = null;
            $filePath = 'images/blankPic.png';
            return $this->insertOneMedia($filePath, $imageContent);

          
        }
        
    }
    public function insertOneMedia(string $filePath, $imageContent)  : Media
    {

        $mediaExists = $this->mediaRepository->getOneWithPath($filePath);

        $extention = substr($filePath,strpos($filePath,'.')+1 );

        $media = [];
        if ( $mediaExists ){
            return $mediaExists;
        }else if ( $imageContent !== null ){
            
            Storage::disk('public')->put($filePath, $imageContent);

            $media['path'] = $filePath;
            $media['alt']= 'image';
            $media['extention']= $extention;

            return $this->mediaRepository->create($media);

        }else{

            $media['path'] = $filePath;
            $media['alt']= 'image';
            $media['extention']= $extention;

            return $this->mediaRepository->create($media);

        }

    }



}