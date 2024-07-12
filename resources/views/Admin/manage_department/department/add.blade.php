
<div class="row" id="DdddepartmentPanel" data-screen-permission-id="22"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> {{ $pageTitle }} </h2>
                
                <ul class="nav navbar-right panel_toolbox justify-content-end">
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul> 
                <div class="clearfix"></div>

            </div>
            <div class="x_content {{ $Collapse  }}">
                @foreach ($errors->all() as $key => $error)
                    <div class="col-mb-12 col-lg-12">
                        <div class="alert alert-danger" style="font-size: 13.5px;">
                            {{ $error }} !!!
                        </div>
                    </div>    
                @endforeach

                <div class="col-mb-12 col-lg-12">
                    <form wire:submit.prevent="saveDepartment">

                        @csrf

                        <div class="col-md-6 col-lg-6 Departmentlabel">
                            <div class="form-group">
                                <label>Department Name<span class="danger">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_department.name" id="name" placeholder="Place Department Name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 Departmentlabel">
                            <div class="form-group">
                                <label>Department Office Location<span class="danger">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_department.office_location" id="office_location" placeholder="Place Department office_location" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"> {{ $update ? 'Update Department' : 'Save Department' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
