<script>
    $(document).ready(function () {
        $('.crud-show-table--delete').on('click', function (e) {
            e.preventDefault()
            Swal.fire({
                title: '削除しますか?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: ' はい ',
                cancelButtonText: ' いいえ ',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        '削除!',
                        '成功'
                    )
                    $(this).closest('form').submit()
                }
            })
        })
    })
</script>
