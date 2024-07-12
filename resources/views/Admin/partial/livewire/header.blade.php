<div class="page-title" wire:ignore>
    <div class="title_left">

            <h3>{{ explode(" ", $pageTitle)[0] }}  </h3>

    </div>
    <div class="title_right cleanuphead text-right">
            <button type="button" class="cleanup-button" wire:click="Cleanup">
            <i class="fa fa-signing"></i> Sweep up                    
        </button>
    </div>
</div>

<div class="clearfix"></div>

<div wire:loading wire:target="video">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <img  src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading..."> Uploading Lecture...'
        </div>
    </div>
</div>
<div wire:loading wire:target="Cleanup">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <img  src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading..."> Sweeping Up ...'
        </div>
    </div>
</div>
<div wire:loading wire:target="page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <img  src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading..."> Loading ...'
        </div>
    </div>
</div>
<div wire:loading wire:target="csv_file">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <img  src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading..."> Validating CSV...'
        </div>
    </div>
</div>
<div wire:loading wire:target="saveCourseAlign">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <img  src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading..."> Storing Alignments...!!!'
        </div>
    </div>
</div>
