<x-title :params="$users ? config('users.update') : config('users.create')" />

<form action="{{ config('users.cu_route') }}{{ $user ? $user->id : '' }}" method="POST" enctype="multipart/form-data">
@csrf

    <x-select :params="$companies" value="{{ $user ? $user->company_id : '' }}"/>
    <x-select :params="$companies" value="{{ $user ? $user->company_id : '' }}"/>

    <x-form-input :params="config('users.form.name')" value="{{ $user ? $user->name : '' }}"/>
    <x-form-input :params="config('users.form.lastname')" value="{{ $user ? $user->lastname : '' }}"/>
    <x-form-input :params="config('users.form.email')" value="{{ $user ? $user->email : '' }}"/>

    <div class="columns">

        <div class="column is-half">

        <div class="field">
            <label class="label">User Roles</label>
        
            <div class="control">

                @if ( count($allroles) > 0)
                
                    @foreach ($allroles as $role)
        
                        <label class="checkbox is-block">
                            <input type="checkbox" wire:model="uroles" value="{{$role->id}}"> {{ $role->name }}
                        </label>
        
                    @endforeach
    
                @else  
                    <p>{{ config('roles.list.noitem') }}</p>
                @endif                                       
                            
            </div>
        </div>

        </div>


        <div class="column is-half">

            <div class="field">
                <label class="label">User Permissions</label>
            
                <div class="control">
            
                    @if ( count($permissions) > 0)
                
                    @foreach ($permissions as $perm)
        
                        <label class="checkbox is-block">
                            <input type="checkbox" name="perm{{$perm->id}}" value="{{$perm->id}}" 
                            @checked(in_array($perm->id,$available_usr_perms))> {{ $perm->name }}
                        </label>
        
                    @endforeach
        
                    @else  
                        <p>{{ config('permissions.list.noitem') }}</p>
                    @endif          
                                
                </div>
            </div>

        </div>

    </div>

    <div class="buttons is-right">
        <button class="button is-dark">{{ config('users')[$action]['submitText'] }}</button>
    </div>

</form>
    
    