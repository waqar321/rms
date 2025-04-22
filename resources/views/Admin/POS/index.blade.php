@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>    
                <livewire:admin.pos.index :permission="$permission"/>    
            </div>
        @else 
           
            <div>    
                <livewire:admin.pos.index : />    
            </div>
        @endif
@endsection 

