@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>    
                <livewire:admin.item-category.index :permission="$permission"/>    
            </div>
        @else 

            <div>    
                <livewire:admin.unit-type.index : />    
            </div>
        @endif
@endsection 

