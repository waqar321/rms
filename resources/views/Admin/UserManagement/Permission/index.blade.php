@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>    
                <livewire:admin.user-management.permission.index :permission="$permission"/>    
            </div>
        @else 
            <div>    
                <livewire:admin.user-management.permission.index : />    
            </div>
        @endif
@endsection 

