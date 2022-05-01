<script>
    $(document).ready(function () {
        $('#admin-crud-search-form [type="reset"]').on('click', function () {
            $('#admin-crud-search-form .search-form-control').val('')
            $('#admin-crud-search-form').submit()
        })

        // radio button
        $('#all-check-box').on('click', function () {
            var value = $(this).prop('checked');
            $('.all-check-box-item').prop('checked', value);
        })
        $('.all-check-box-item').on('change', function () {
            var hasCheck = []
            $('.all-check-box-item').each(function () {
                if ($(this).prop('checked')) {
                    hasCheck.push($(this).val())
                }
            })

            if (hasCheck.length === $('.all-check-box-item').length) {
                $('#all-check-box').prop('checked', true)
            } else {
                $('#all-check-box').prop('checked', false)
            }
        })

        // $('.crud-index-table-delete').on('click', function (e) {
        //     e.preventDefault()
        //     var cf = confirm('削除しますか')
        //     if (!cf) {
        //         return false
        //     }
        //     $(this).closest('form').submit()
        // })

        $('.crud-index-table-delete').on('click', function(e) {
            e.preventDefault()
            Swal.fire({
                title: '削除しますか?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: ' はい ',
                cancelButtonText: ' いいえ ',
                reverseButtons: true

            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        '削除!',
                        // 'ファイルが削除されました.',
                        '成功'
                    )
                    $(this).closest('form').submit()
                }
            })

        })

        $('.admin-crud-paginator-select').on('change', function (e) {
            const $this = $(this)
            let currentUrl = $this.attr('data-url')
            currentUrl += '&limit=' + $this.val()
            window.location.href = currentUrl
        })
    })
</script>
