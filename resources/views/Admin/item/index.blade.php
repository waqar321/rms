@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>    
                <livewire:admin.item.index :permission="$permission"/>    
            </div>
        @else 
            <div>    
                <livewire:admin.item.index : />    
            </div>
        @endif
@endsection 

