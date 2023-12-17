<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Populate {{ $populate_defaults['is_for_project'] ? 'for Project' :' for End Product' }}</h1>
    <h2 class="subtitle has-text-weight-light">Populate {{ $populate_defaults['is_for_project'] ? 'Project' :' End Product' }} with Predefined Definitions</h2>
</header>


<div class="notification is-link is-light">
    This app defines <u>predefined</u> definitions for projects and/or End Products. These definitions are based on generic Systems Engineering flow and are limited<br>
    These definitions can be used as starting point with <strong>tailoring/customisation</strong>. It is recommended to use these predefined definitions and modify them to your needs.
</div>


<div class="content">

    <h2 class="subtitle has-text-weight-light">Predefined Definitions</h2>

    <table class="table is-fullwidth">

        <caption class="mb-4">Project Phases</caption>

        @foreach ($populate_defaults['phases'] as $phase)
        <tr>
            <th>{{$phase->code}}</th>
            <td>{{$phase->name}}</td>
        </tr>
        @endforeach

    </table>



    <table class="table is-fullwidth">

        <caption class="mb-4">Milestones/Decision Gates</caption>

        @foreach ($populate_defaults['milestones'] as $milestone)
        <tr>
            <th>{{$milestone->code}}</th>
            <td>{{$milestone->name}}</td>
        </tr>
        @endforeach
        
    </table>


    <table class="table is-fullwidth">

        <caption class="mb-4">Means of Compliances (MOC)</caption>

        @foreach ($populate_defaults['mocs'] as $moc)
        <tr>
            <th>{{$moc->code}}</th>
            <td>{{$moc->name}}</td>
        </tr>
        @endforeach
        
    </table>



    <table class="table is-fullwidth">

        <caption class="mb-4">Proof of Compliances (MOC)</caption>

        @foreach ($populate_defaults['pocs'] as $poc)
        <tr>
            <th>{{$poc->code}}</th>
            <td>{{$poc->name}}</td>
        </tr>
        @endforeach
        
    </table>






</div>


<a wire:click='doPopulate({{$uid}})' class="button is-dark">
    <span class="icon is-small"><x-carbon-port-input /></span>
    <span>Populate</span>
</a>
