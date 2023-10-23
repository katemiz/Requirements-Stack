<section class="section container">

    <div class="column content">

        <h1 class="title has-text-weight-light is-size-1 has-text-left">Project/Product Selector</h1>
        <h1 class="subtitle has-text-weight-light">Select project/end product you want to use</h1>

        {{-- <input type="text" wire:model='redirect_to'> --}}

        @if ($companies->count() > 1)
        <div class="field">
            <label class="label">Company</label>
            <div class="control">
                <div class="select">
                <select wire:model='company_id' wire:change='getProducts'>
                    <option>Select a company...</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                </select>
                </div>
            </div>
        
            @error('company_id')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>
        @endif

        <table class="table is-fullwidth">

            <thead>
                <tr>
                    <th>Projects</th>
                    <th>End Products</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($products as $prjId => $product)

                    <tr>
                        <td>
                            <span class="subtitle has-text-danger-dark">
                            
                            {{$product['project']['code']}}</span><br>{{$product['project']['title']}}</td>
                        <td>&nbsp;</td>
                        <td><a wire:click='setCurrent({{ $prjId }},0)'>Set As Current</a></td>
                    </tr>

                    @if ($product['ep'] !== null)
    
                        @foreach ($product['ep'] as $ep)
                            <tr>
                                <td>&nbsp;</td>
                                <td>{{$ep->code}} / {{$ep->title}}</td>
                                <td><a wire:click='setCurrent({{ $prjId }},{{ $ep->id }})'>Set As Current</a></td>
                            </tr>
                        @endforeach
                
                    @endif
                
                @endforeach

            </tbody>

        </table>

    </div>

</section>