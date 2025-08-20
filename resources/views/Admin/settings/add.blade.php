

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            @include('Admin.partial.livewire.X_titles')

            <div class="x_content {{ $Collapse  }}">

                @if ($errors->any())
                    @foreach ($errors->all() as $key => $error)

                        <div class="col-mb-12 col-lg-12">
                            <div class="alert alert-danger" style="font-size: 13.5px;">
                                {{ $error }} !!!
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="col-mb-12 col-lg-12">

                    <form wire:submit.prevent="saveSetting">

                        @csrf
                        <!-- =========================== Brand_name ========================== -->
                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group" wire:ignore>
                                <label for="Brand_name">Branch Name</label>

                                <input  id="Brand_name"
                                        class="form-control"
                                        type="text"
                                        name="Brand_name"
                                        data-rule-required="true"
                                        data-msg-required="user name field is required"
                                        wire:model.debounce.500ms="Setting.Brand_name"
                                        placeholder="Please Enter Brand">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group" wire:ignore>
                                <label for="title">Employee Discount</label>

                                <input  id="title"
                                        class="form-control"
                                        type="number"
                                        name="title"
                                        data-rule-required="true"
                                        data-msg-required="user name field is required"
                                        wire:model.debounce.500ms="Setting.employee_discount"
                                        placeholder="Enter Discount %">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                        <!-- =========================== shift_starting_time ========================== -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="shift_starting_time">Shift Starting Time</label>

                                <input id="shift_starting_time"
                                    class="form-control"
                                    type="time"
                                    name="shift_starting_time"
                                    required
                                    wire:model.lazy="Setting.shift_starting_time"
                                    placeholder="Enter Shift Start Time">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>

                        <!-- =========================== shift_ending_time ========================== -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="shift_ending_time">Shift Ending Time</label>

                                <input id="shift_ending_time"
                                    class="form-control"
                                    type="time"
                                    name="shift_ending_time"
                                    required
                                    wire:model.lazy="Setting.shift_ending_time"
                                    placeholder="Enter Shift End Time">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input id="image" class="form-control" type="file"
                                    wire:model="photo" />
                                <small class="form-text text-muted">Optional - Upload Logo</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                @if($Setting->image)
                                    @include('Admin.partial.livewire.imageshow', [
                                                                            'path' => 'storage/'.$Setting->image_path
                                                                        ])
                                @endif
                            </div>
                        </div>


                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"> {{ $Setting->id ? 'Update Setting' : 'Save Setting' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
