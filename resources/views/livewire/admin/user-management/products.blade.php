<div class="right_col" role="main">
    <div class="">
        <div x-data="{}">
            <div class="alert alert-info" role="alert">
                Click "Edit", modify that line data and click "Save".
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>Permission</th>
                    <th width="250"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($permissions as $index => $permission)
                    <tr>
                        <td>
                            @if ($editedPermissionIndex === $index || $editedPermissionField === $index . '.title')
                                <input type="text"
                                    @click.away="$wire.editedPermissionField === '{{ $index }}.title' ? $wire.savePermission({{ $index }}) : null"
                                    wire:model.defer="permissions.{{ $index }}.title"/>
                                @if ($errors->has('permissions.' . $index . '.title'))
                                    <div class="invalid-feedback">{{ $errors->first('permissions.' . $index . '.title') }}</div>
                                @endif
                            @else
                                <div class="cursor-pointer" wire:click="editPermissionField({{ $index }}, 'title')">
                                    {{ $permission['title'] }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($editedPermissionIndex === $index || (isset($editedPermissionField) && (int)(explode('.',$editedPermissionField)[0])===$index))
                                <button class="btn btn-sm btn-success mr-1"
                                        wire:click.prevent="savePermission({{$index}})">
                                    Save
                                </button>
                            @else
                                <button class="btn btn-sm btn-primary"
                                        wire:click.prevent="editPermission({{$index}})">
                                    Edit
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>