@include('emails.partials.header')

<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation"
    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f36f24;" width="100%">
    <tbody>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                    role="presentation"
                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 550px;" width="550">
                    <tbody>
                        <tr>
                            <td class="column"
                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 15px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                width="100%">
                                <table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                    width="100%">
                                    <tr>
                                        <td style="padding-left:10px;padding-right:10px;padding-top:25px;">
                                            <div style="font-family: sans-serif">
                                                <div
                                                    style="font-size: 14px; font-family: Cabin, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 16.8px; color: #ffffff; line-height: 1.2;">
                                                    <p style="margin: 0; font-size: 30px; text-align: center;">
                                                        <strong><span style="font-size:38px;">Hello,
                                                                {{ isset($employee->name) ? $employee->name : 'Mark' }}!</span></strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                    width="100%">
                                    <tr>
                                        <td style="padding-left:10px;padding-right:10px;padding-top:10px;">
                                            <div style="font-family: sans-serif">
                                                <div
                                                    style="font-size: 14px; mso-line-height-alt: 21px; color: #ffffff; line-height: 1.5; font-family: Cabin, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                    {{-- <p
                                                        style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 33px;">
                                                        <span style="font-size:22px;color:#f9c253;">
                                                            We've saved your
                                                            seat at:</span></p> --}}
                                                    <p
                                                        style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 51px;">
                                                        <span
                                                            style="font-size:34px;">{{ isset($subject) ? $subject : 'Something great will happened' }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0" cellpadding="0" cellspacing="0" class="addon_block"
                                    role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                    width="100%">
                                    <tr>
                                        <td style="width:100%;padding-right:0px;padding-left:0px;">
                                            <div align="center" style="line-height:10px"><img alt="Calendar animation"
                                                    src="https://media0.giphy.com/media/iWYbVCsOhyHLYX0NSx/giphy.gif?cid=20eb4e9dx91gx27zwu9p5sgn2cvzjop32aw16pu8azhcw4o4&rid=giphy.gif&ct=s"
                                                    style="display: block; height: auto; width: 138px; max-width: 100%;"
                                                    title="Calendar animation" width="138" /></div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation"
    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                    role="presentation"
                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 550px;" width="550">
                    <tbody>
                        <tr>
                            <td class="column"
                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                width="100%">
                                <table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                    width="100%">
                                    <tr>
                                        <td
                                            style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:20px;">
                                            <div style="font-family: sans-serif">
                                                <div
                                                    style="font-size: 14px; font-family: Cabin, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 16.8px; color: #393d47; line-height: 1.2;">
                                                    <p style="margin: 0; font-size: 14px; text-align: center;"><span
                                                            style="font-size:15px;"><strong>Details</strong></span></p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                <table border="0" cellpadding="0" cellspacing="0" class="divider_block"
                                    role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                    width="100%">
                                    <tr>
                                        <td style="padding-bottom:10px;padding-left:10px;padding-right:10px;">
                                            <div align="center">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="10%">
                                                    <tr>
                                                        <td class="divider_inner"
                                                            style="font-size: 1px; line-height: 1px; border-top: 3px solid #F9C253;">
                                                            <span> </span></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                    width="100%">
                                    <tr>
                                        <td style="padding-bottom:20px;padding-left:10px;padding-right:10px;">
                                            <div style="font-family: Arial, sans-serif">
                                                <div
                                                    style="font-size: 14px; font-family: 'Cabin', Arial, 'Helvetica Neue', Helvetica, sans-serif; mso-line-height-alt: 16.8px; color: #175df1; line-height: 1.2;">
                                                    <p style="margin: 0; font-size: 14px; text-align: center;"><span
                                                            style="font-size:38px;"><strong>AGENDA</strong></span></p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation"
    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                    role="presentation"
                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f0f8ff; color: #000000; width: 550px;"
                    width="550">
                    <tbody>
                        <tr>
                            <td class="column"
                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                width="25%">
                                <table border="0" cellpadding="0" cellspacing="0" class="image_block"
                                    role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                    width="100%">
                                    <tr>
                                        <td
                                            style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;width:100%;">
                                            <div align="center" style="line-height:10px"><img alt="Topic Icon"
                                                    src="images/mobile-app__1_.png"
                                                    style="display: block; height: auto; border: 0; width: 64px; max-width: 100%;"
                                                    title="Topic Icon" width="64" /></div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="column"
                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                width="75%">
                                <table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                    width="100%">
                                    <tr>
                                        <td
                                            style="padding-bottom:10px;padding-left:20px;padding-right:20px;padding-top:10px;">
                                            <div style="font-family: Arial, sans-serif">
                                                <div
                                                    style="font-size: 14px; font-family: 'Cabin', Arial, 'Helvetica Neue', Helvetica, sans-serif; mso-line-height-alt: 16.8px; color: #175df1; line-height: 1.2;">
                                                    
                                                    <p style="margin: 0; font-size: 14px; text-align: left;"><span
                                                        style="font-size:18px;"><strong><span style="">
                                                                Leave From:
                                                                {{ isset($employee) ? $employee->name : 'Mark Approveal'  }}</span></strong></span>
                                                     </p>
                                                    <p style="margin: 0; font-size: 14px; text-align: left;"><span
                                                            style="font-size:18px;"><strong><span style="">
                                                                    Leave From:
                                                                    {{ isset($date_from) ? $date_from : 'August 4, 2022'  }}</span></strong></span>
                                                    </p>
                                                    <p style="margin: 0; font-size: 14px; text-align: left;"><span
                                                            style="font-size:18px;"><strong><span style="">
                                                                    Leave to:
                                                                    {{ isset($date_to) ? $date_to : "August 4, 2021" }}</span></strong></span>
                                                        <p style="margin: 0; font-size: 14px; text-align: left;"><span
                                                                style="font-size:18px;"><strong><span style="">
                                                                        Total Days:
                                                                        {{ isset($total_days) ? $total_days : "2" }}</span></strong></span>
                                                        </p>
                                                        <p style="margin: 0; font-size: 14px; text-align: left;"><span
                                                                style="font-size:18px;"><strong><span style="">
                                                                        Remaining Days:
                                                                        {{ isset($remaining_days) ? $remaining_days : "3" }}</span></strong></span>
                                                        </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>


@include('emails.partials.footer')
