<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
    <meta name="format-detection" content="telephone=no"/>

    <!-- MESSAGE SUBJECT -->
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="style.css">

</head>

<!-- BODY -->
<!-- Set message background color (twice) and text color (twice) -->
<body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%">

<!-- SECTION / BACKGROUND -->
<!-- Set message background color one again -->
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;">

            <!-- WRAPPER -->
            <!-- Set wrapper width (twice) -->
            <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" class="wrapper">
            <!-- HEADER -->
            {{ $header ?? '' }}

            <!-- PARAGRAPH -->
                <tr>
                    <td align="center" valign="top" class="content">
                        {{ Illuminate\Mail\Markdown::parse($slot) }}
                    </td>
                </tr>


                <!-- LINE -->
            {{ $underline ?? '' }}


            <!-- FOOTER -->
            {{ $footer ?? '' }}

            <!-- End of WRAPPER -->
            </table>

            <!-- End of SECTION / BACKGROUND -->
        </td>
    </tr>
</table>

</body>
</html>
