<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center" style="padding:0px">
            <table class="button-table" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td align="center">
                        <table border="0" cellpadding="0" cellspacing="0" align="center"
                               style="max-width: 240px; min-width: 120px; border-collapse: collapse; border-spacing: 0; padding: 0;">
                            <tr>
                                <td align="center" style="padding:0px" valign="middle">
                                    <a target="_blank" class="btn btn-{{ $color ?? 'primary' }}" href="{{$url}}">
                                        {{ $slot }}
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{--<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">--}}
{{--    <tr>--}}
{{--        <td align="center">--}}

{{--            <table border="0" cellpadding="0" cellspacing="0" align="center"--}}
{{--                   style="max-width: 240px; min-width: 120px; border-collapse: collapse; border-spacing: 0; padding: 0;">--}}
{{--                <tr>--}}
{{--                    <td align="center" valign="middle">--}}
{{--                        <a target="_blank" class="btn btn-{{ $color ?? 'primary' }}" href="{{$url}}">--}}
{{--                            {{ $slot }}--}}
{{--                        </a>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            </table>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--</table>--}}

