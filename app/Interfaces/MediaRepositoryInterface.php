<?php


namespace App\Interfaces;

interface MediaRepositoryInterface{
    
    public function createMedia(string $filePath,$imageContent);

}