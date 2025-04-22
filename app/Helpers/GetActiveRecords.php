
<?php
use App\Models\Admin\SideBar;

function getPageTitle()
{
    $all_segments = request()->segments();
    $pageTitle = implode("/", $all_segments);

    if (count($all_segments) == 2) 
    {
        $pageTitle = implode("/", $all_segments);
    }

    $sideBar = SideBar::where('url', $pageTitle)->first();
    $title = '';

    if ($sideBar) {
        $title = $sideBar->title;
    }

    return $title;
}


?>