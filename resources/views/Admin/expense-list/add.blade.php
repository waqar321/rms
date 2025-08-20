

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

                    <form wire:submit.prevent="saveExpenseItem">

                        @csrf

                        <!-- =========================== title ========================== -->
                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group" wire:ignore>
                                <label for="title">Expense Item *</label>

                                <input  id="title"
                                        class="form-control" type="text"
                                        name="title"
                                        data-rule-required="true"
                                        data-msg-required="user name field is required"
                                        wire:model.debounce.500ms="ExpenseList.name"
                                        placeholder="Enter Expense Title">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>


                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"> {{ $ExpenseList->id ? 'Update Expense' : 'Save Expense' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
