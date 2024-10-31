@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>    
                <livewire:admin.pos.data-entry.index :permission="$permission"/>    
            </div>
        @else 
       
            <div>    
                <livewire:admin.pos.data-entry.index : />    
            </div>
        @endif
@endsection 

