<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Livewire\Component;

class EitherOrRule implements Rule
{
    protected $attributefield;
    protected $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
        // dd($this);
        // $this->component->videoSet;
        // $this->component->URLvideoSet;
        // dd($this->component->videoSet);
        // dd($this->component->URLvideoSet);
        // $this->video = $video;
        // $this->video_url = $video_url;
        // echo $video_url."<br>";
        // dd($video);
        
        // if($this->video != 'empty')
        // {
        //     echo "video found";
        // }
        // if($this->video_url != 'empty')
        // {
        //     echo "video url found";
        // }
        // dd($this->video);
    }
    public function passes($attribute, $value)
    {
        return ($this->component->video != "empty" && $this->component->video_url != "empty");

        // dd($this->attributefield);
        // Check if both fields are not empty
        // return empty($value) || empty(request()->input($this->video));
    }
    public function message()
    {

        return 'Either upload a file or provide a URL, but not both.';
    }
}
