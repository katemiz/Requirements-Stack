<section class="section container">

    <script>

        window.addEventListener('ConfirmModal',function(e) {

            let sa_title, sa_text, confirmText, cancelText
            let dispatchRoute, dispatchData

            switch (e.detail.type) {

                case 'test':
                    sa_title = 'Do you really want to delete this test?'
                    sa_text = 'Once deleted, there is no reverting back!'
                    confirmText = 'Delete'
                    cancelText ='Oops ...'

                    dispatchRoute = 'onDeleteConfirmed'
                    dispatchData = {type:e.detail.type}
                    break;

                case 'freeze':

                    sa_title = 'Test will be frozen!'
                    sa_text = 'Once frozen, no editing is possible.'
                    confirmText = 'Freeze'
                    cancelText ='Cancel'

                    dispatchRoute = 'onFreezeConfirmed'
                    dispatchData = {}
                    break;


                case 'revise':

                    sa_title = 'Do you want revise this test?'
                    sa_text = 'New revision will be editable.'
                    confirmText = 'Revise'
                    cancelText ='Cancel'

                    dispatchRoute = 'onReviseConfirmed'
                    dispatchData = {}
                    break;

                case 'attach':

                    sa_title = 'Do you want delete attached file?'
                    sa_text = 'Once deleted, there is no reverting back!'
                    confirmText = 'Delete File'
                    cancelText ='Cancel'

                    dispatchRoute = 'deleteAttach'
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











    </script>

    @switch($action)

        @case('FORM')
            @include('projects.tests.tests-form')
            @break

        @case('VIEW')
            @include('projects.tests.tests-view')
            @break

        @case('LIST')
        @default
            @include('projects.tests.tests-list')
            @break

    @endswitch

</section>

