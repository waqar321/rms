@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>
                <livewire:admin.item-category.index :permission="$permission"/>
            </div>
        @else

            <div>
                <livewire:admin.item-category.index : />
            </div>
        @endif
@endsection

