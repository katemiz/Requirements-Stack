

    <section class="section container">
    
        <div class="column content">

            <h1 class="title has-text-weight-light is-size-1 has-text-left">Project/Product Selector</h1>
            <h1 class="subtitle has-text-weight-light">Select project/end product you want to use</h1>



            <div class="card">

                <div class="card-content">
                  <div class="media">
                    <div class="media-left">
                      <figure class="image is-48x48">
                        <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                      </figure>
                    </div>
                    <div class="media-content">
                      <p class="title is-4">John Smith</p>
                      <p class="subtitle is-6">@johnsmith</p>
                    </div>
                  </div>
              
                  <div class="content">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Phasellus nec iaculis mauris. <a>@bulmaio</a>.
                    <a href="#">#css</a> <a href="#">#responsive</a>
                    <br>
                    <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
                  </div>
                </div>
            </div>
    

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

            {{-- <pre>
            @php
                print_r($products)
            @endphp
            </pre> --}}
{{-- 
            @foreach ($products as $product)

                <p>{{$product['project']['code']}}</p>

                @if ($product['ep'] !== null)

                    @foreach ($product['ep'] as $ep)
                        <p>{{$ep->code}} / {{$ep->title}}</p>      
                    @endforeach
             
                @endif
                
            @endforeach --}}


    
            <table class="table is-fullwidth">


                <thead>
                    <tr>
                        <th>Projects</th>
                        <th>End Products</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($products as $prjId => $product)

                        <tr>

                            <td>{{$product['project']['code']}}<br>{{$product['project']['title']}}</td>
                            <td>&nbsp;</td>
                            <td><a wire:click='setCurrent({{ $prjId }},0)'>Set As Current</a></td>

                        </tr>

                    

        
                        @if ($product['ep'] !== null)
        
                            @foreach ($product['ep'] as $ep)
                                <p>{{$ep->code}} / {{$ep->title}}</p>      

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
    
    