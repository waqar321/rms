
@push('styles')


    <style>
        .testForm
        {
            display: block !important;
            margin-top: 0em !important;
            unicode-bidi: isolate !important;
            padding-top: 20px;
        }

    </style>
@endpush

<div class="row" data-screen-category-id="22">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="col-md-4 col-lg-4">
                    <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Title...">
                </div>

                @include('Admin.partial.livewire.ClearDeleteButtons', ['showDeleteButton' => 'true', 'modelName' => 'category'])

                <ul class="nav navbar-right panel_toolbox justify-content-end">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>

                <div class="clearfix"></div>

            </div>
            <div class="x_content">

                        <!-- <div class="col-lg-4" wire:ignore>
                            <select id="framework" name="framework[]" multiple class="form-control">
                                    @foreach($availableColumns as $column)
                                        @if($column != 'Image' && $column != 'Actions')
                                            <option value="{{ $column }}">{{ ucfirst($column) }}</option>
                                        @endif
                                    @endforeach
                            </select>
                        </div>

                        @include('Admin.partial.livewire.exportButtons')
                        <hr> -->
                        <div class="container-fluid" style="margin-left: 13px; padding-top: 10px;">
                            <div class="row">
                                @include('Admin.partial.livewire.states', ['showDeleteButton' => 'true', 'states' => $states])
                            </div>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <!-- <th> </th> -->
                                    @foreach($availableColumns as $column)
                                            <th>{{ $column }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @if($readyToLoad)
                                    @forelse($Expenses as $Expense)
                                        <tr>
                                            <!-- <td>
                                                <input type="checkbox" wire:model="selectedRows.{{ $Expense->id }}">
                                            </td> -->
                                            <td>{{ $Expense->id }}</td>
                                            <td>{{ $Expense->item->name ?? ''  }}</td>
                                            <td>{{ $Expense->amount  }}</td>
                                            <td>{{ $Expense->description  }}</td>
                                            <td>{{ $Expense->created_at->format('d M Y, h:i A') }}</td>

                                            <td>
                                                @if($Expense->is_active == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $Expense->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $Expense->id }}, 1)"></span>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- <a data-screen-unit_type-id="23" wire:click="EditData({{ $Expense->id }})" class="btn btn-primary">Edit</a> --}}
                                                <button data-screen-unit_type-id="24" onclick="confirmDelete('{{ $Expense->id }}')" class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center"> <h2> No Expense Found!!! </h2></td>
                                        </tr>
                                    @endforelse
                                @endif

                                @include('Admin.partial.livewire.loadingData')

                            </tbody>
                        </table>

                        @include('Admin.partial.livewire.pagination', ['ModelListing' => $Expenses, 'Model' => 'categoryListing'])

            </div>
        </div>
    </div>
</div>
</div>


@push('scripts')


<script>
   $(document).ready(function()
   {

        $('#framework').multiselect({
            nonSelectedText: 'Select Framework',
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            buttonWidth:'400px'
        });

        // $('.ExportButtonLivewire').on('click', function()
        // {
        //     var selectedColumns = $('#framework').val();
        //     Livewire.emit('selectedColumns', selectedColumns.join(', '), $(this).data('export-type'));
        // });

    });
</script>

@endpush
