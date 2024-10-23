<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $dbMovie = new Movie;
        //         $dbMovie->title = $data['title'];
        //         $dbMovie->overview = $data['overview'];
        //         $dbMovie->original_language = $data['original_language'];
        //         $dbMovie->release_date = $data['release_date'];
        //         $dbMovie->api_id = $data['id'];
        //         $dbMovie->media_id = $data['media_id'];
        //         $dbMovie->price = $prices[mt_rand(0,6)];
        //         $dbMovie->save();
        return [
            'title' => 'required|string|max:255',         // Title is required, string, max 255 characters
            'overview' => 'string|max:255',      // Director is required, string, max 255 characters
            'original_language' => 'required|string|max:255',      // Director is required, string, max 255 characters
            'release_date' => 'required|date|date_format:Y-m-d|after_or_equal:1888-01-01|before_or_equal:today', // Valid year range
            'api_id' => 'required|integer',          // Genre is optional, max 100 characters
            'media_id' => 'integer|required|exists:media,id',  // Rating is optional, between 0 and 10
            'price' => 'required|integer',   // Description is optional, max 1000 characters
        ];
    }
}
