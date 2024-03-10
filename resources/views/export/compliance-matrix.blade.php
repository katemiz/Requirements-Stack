<x-layout>
<section class="section container">

    <script src="{{ asset('js/table2excel.js') }}"></script>

    <header class="my-6">
        <h1 class="title has-text-weight-light is-size-1">Compliance Matrix</h1>
        <h2 class="subtitle has-text-weight-light">Requirements vs Compliance Status</h2>
    </header>

    @if (count($requirements) > 0)

        <div class="column has-text-right">

            <a href="javascript:tableToExcel()">

                <span class="icon-text">

                    <span class="icon">
                        <x-carbon-document-export />
                    </span>
                    <span>Excel Export</span>
                </span>
            </a>

        </div>

        @foreach ($requirements as $rtype => $subrequirements)


        <table class="table is-fullwidth" id="CMMAtrix">

            <caption>Compliances Matrix for {{ $rtype == 'GR' ? 'General Requirements':'Technical Requirements' }}</caption>

            <thead>
                <tr>
                    <th>No</th>
                    {{-- <th>Requirement Type</th> --}}
                    <th>Requirement Definition</th>
                    {{-- <th>End Products (If any)</th>
                    <th>Compliance</th>
                    <th>Contractor Comments</th> --}}
                </tr>
            </thead>

            <tbody>

                @foreach ($subrequirements as $item)
                <tr>
                    <td class="is-narrow">R{{ $item->requirement_no }} R{{ $item->revision }}</td>
                    <td>
                        {{-- <p class="subtitle mb-3">{{ config('requirements.form.rtype.options')[$item->rtype] }}</p> --}}
                        <div class="content">
                        {!! $item->text !!}
                        </div>
                    </td>
                    {{-- <td>
                        @foreach ($item->endproducts as $ep)
                        <span class="tag is-info">{{ $ep->code }}</span><br>
                        @endforeach
                    </td> --}}
                    {{-- <td>
                        <label class="checkbox is-size-7">
                        <input type="checkbox"> Comply
                        </label>
                        <label class="checkbox is-size-7">
                            <input type="checkbox"> Partially Comply
                            </label>
                            <label class="checkbox is-size-7">
                                <input type="checkbox"> Not Comply
                            </label>
                    </td> --}}
                    {{-- <td>&nbsp;</td> --}}
                </tr>
                @endforeach

            </tbody>
        </table>

        @endforeach()


        <script>
            var table2excel = new Table2Excel();

            function tableToExcel() {
                table2excel.export(document.querySelectorAll('table'));
            }
        </script>

    @else
        <div class="notification is-link is-light">No requirements found</div>

    @endif


</section>
</x-layout>
