@extends('Admin.layout.main')

@section('content')


        @if(request()->has('id'))
            <div>    
                <livewire:admin.setting-field.index :permission="$permission"/>    
            </div>
        @else 

            <div>    
                <livewire:admin.setting-field.index : />    
            </div>
        @endif
@endsection 

