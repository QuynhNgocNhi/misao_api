<style type="text/css">
    /* スマホ */
    @media screen and (max-width: 767px) {
        .container, #mail-footer {
            max-width: 95%;
        }

         {
            max-width: 50%;
        }
    }
    /* PC */
    @media screen and (min-width: 768px) {
        .container, #mail-footer {
            max-width: 50%;
        }
    }

</style>

<div id="mail-body" style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; width: 100%!important; min-width: 100%; height: 100%;">
    <div class="container" style="margin: 0 auto">
        <table border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width: 100%; margin:0; padding:0;">
            @yield('body')

            @yield('button')

            <tr>
                <td id="mail-footer" style="padding: 20px; font-size: 70%; color: #777777; border-top: 1px solid #777777;">
                    <p>
                        © {{ date('Y') }} {{ config('app.name') }}
                    </p>
                </td>
            </tr>
        </table>
    </div>
</div>
