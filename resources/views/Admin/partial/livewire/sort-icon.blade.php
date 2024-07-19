@if ($sortBy === $field)
    @if ($sortDirection === 'asc')
        <i class="fas fa-sort-up"></i>
    @else
        <i class="fas fa-sort-down"></i>
    @endif
@endif

