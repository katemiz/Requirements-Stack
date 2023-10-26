<section class="section container">

    <script>

        window.addEventListener('ConfirmDelete',function(e) {

            let sa_title = 'Do you really want to delete this '+e.detail.type+'?'
            let sa_text = 'Once deleted, there is no reverting back!'

            let confirmText = 'Delete'
            let cancelText ='Oops ...'

            if (e.detail.type === 'requirement') {
                sa_title = 'Do you really want to delete this requirement and its linked verifications?'
            }

            if (e.detail.type === 'freeze') {
                sa_title = 'Requirement will be frozen!'
                sa_text = 'Once frozen, no editing is possible.'

                confirmText = 'Freeze'
                cancelText ='Cancel'
            }


            Swal.fire({
                title: sa_title,
                text: sa_text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,

            }).then((result) => {
                if (result.isConfirmed) {

                    if (e.detail.type === 'freeze') {
                        Livewire.dispatch('onFreezeConfirmed')
                    } else {
                        Livewire.dispatch('onDeleteConfirmed', {type:e.detail.type})
                    }

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
