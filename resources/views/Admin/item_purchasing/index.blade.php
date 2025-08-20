@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>
                <livewire:admin.item-purchasing.index :permission="$permission"/>
            </div>
        @else

            <div>
                <livewire:admin.item-purchasing.index : />
            </div>
        @endif
@endsection

