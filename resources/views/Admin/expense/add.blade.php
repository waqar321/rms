

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
                    <form wire:submit.prevent="saveExpense">
                        @csrf

                        <div class="col-md-6 col-sm-6 col-xs-12 d-none" >
                            <div class="form-group" wire:ignore>
                                <label>Vendor  <span class="danger">*</span></label>
                                <select class="form-control Select2DropDown" data-id="user_id" id="user_id" name="user_id">
                                    <option value="">-- Select user -- </option>
                                        @foreach($users as $user_id => $name)
                                            <option value="{{ $user_id }}" {{ $Expense->user_id == $user_id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 d-none" >
                            <div class="form-group" wire:ignore>
                                <label>Item <span class="danger">*</span></label>
                                <select class="form-control Select2DropDown" data-id="item_id" id="item_id" name="item_id" >
                                    <option value="">-- Select Item --</option>
                                        @foreach($items as $item_id => $item_name)
                                            <option value="{{ $item_id }}">{{ $item_name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group" wire:ignore>
                                <label for="user_expense_item">Select Expense Item  </label>
                                <!-- <select class="form-control Select2DropDown" data-id="user_expense_item" id="user_expense_item" name="user_expense_item"> -->
                                <select class="form-control Select2DropDown" data-id="user_expense_item" id="user_expense_item" name="user_expense_item">
                                    <option value="">-- Select Expense Item --</option>
                                        @foreach($expenseItems as $expense_item_id => $expense_item_title)
                                            <option value="{{ $expense_item_id }}" {{ $Expense->item_id == $expense_item_id ? 'selected' : '' }}>{{ $expense_item_title }}</option>
                                        @endforeach
                                </select>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>

                        <!-- Category -->
                        @if(!$Update)
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="new_item">Add New Expense Item</label>
                                    <input id="new_item" class="form-control new_item" type="text" name="new_item"
                                        wire:model.defer="Expense.item_id"
                                        placeholder="e.g., Travel, Food, Rent">
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div>
                        @endif

                        <!-- Description -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control"
                                        name="description"
                                        wire:model.defer="Expense.description"
                                        placeholder="Enter description"></textarea>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input id="amount" class="form-control" type="number" step="0.01"
                                    name="amount"
                                    wire:model.defer="Expense.amount"
                                    placeholder="Enter amount">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="col-md-12 col-lg-12 mt-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{ $Expense->id ? 'Update Expense' : 'Save Expense' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
