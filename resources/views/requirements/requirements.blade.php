<section class="section container">

    <script>

        window.addEventListener('ConfirmDelete',function(e) {

            let sa_title = 'Do you really want to delete this '+e.detail.type+'?'
            let sa_text = 'Once deleted, there is no reverting back!'

            console.log("AAAAAAAA",e.detail.type)

            Swal.fire({
                title: sa_title,
                text: sa_text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Ooops ...',

            }).then((result) => {

                if (result.isConfirmed) {

                    console.log("BBBBB",e.detail.type)

                    Livewire.dispatch('onDeleteConfirmed', {type:e.detail.type})
                } else {
                    return false
                }
            })
        });

        window.addEventListener('attachDeleted',function(e) {

            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'File/Attachment has been deleted',
                showConfirmButton: false,
                timer: 1500
            })
        })

        function showModal(modalNo) {
            document.getElementById(modalNo).classList.add('is-active')
        }

        function hideModal(modalNo) {
            document.getElementById(modalNo).classList.remove('is-active')
        }

    </script>

    @switch($action)

        @case('VERIFICATION')
            @include('requirements.verifications-form')
            @break

        @case('FORM')
            @include('requirements.requirements-form')
            @break

        @case('VIEW')
            @include('requirements.requirements-view')
            @break

        @case('LIST')
        @default
            @include('requirements.requirements-list')
            @break

    @endswitch

</section>
