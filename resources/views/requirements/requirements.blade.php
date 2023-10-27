<section class="section container">

    <script>

        window.addEventListener('ConfirmDelete',function(e) {

            let sa_title, sa_text, confirmText, cancelText
            let dispatchRoute, dispatchData

            switch (e.detail.type) {

                case 'requirement':

                    sa_title = 'Do you really want to delete this requirement and its linked verifications?'
                    sa_text = 'Once deleted, there is no reverting back!'
                    confirmText = 'Delete'
                    cancelText ='Oops ...'

                    dispatchRoute = 'onDeleteConfirmed'
                    dispatchData = {type:e.detail.type}
                    break;

                case 'verification':

                    sa_title = 'Do you really want to delete this verification?'
                    sa_text = 'Once deleted, there is no reverting back!'
                    confirmText = 'Delete'
                    cancelText ='Oops ...'

                    dispatchRoute = 'onDeleteConfirmed'
                    dispatchData = {type:e.detail.type}
                    break;

                case 'freeze':

                    sa_title = 'Requirement will be frozen!'
                    sa_text = 'Once frozen, no editing is possible.'
                    confirmText = 'Freeze'
                    cancelText ='Cancel'

                    dispatchRoute = 'onFreezeConfirmed'
                    dispatchData = {}

                    break;


                case 'revise':

                    sa_title = 'Do you want revise this requirement?'
                    sa_text = 'New revision will be editable.'
                    confirmText = 'Revise'
                    cancelText ='Cancel'

                    dispatchRoute = 'onReviseConfirmed'
                    dispatchData = {}
                    break;
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
                    Livewire.dispatch(dispatchRoute, dispatchData)
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
