
@if($field != 'Status' && $field != 'Action')
    @if ($sortByRealTime === $field)
        @if ($sortDirection === 'asc')
            <i class="fa fa-sort-up"></i>
        @else
            <i class="fa fa-sort-down"></i>
        @endif
    @else
        <i class="fa fa-sort-up"></i>
    @endif 
@endif 