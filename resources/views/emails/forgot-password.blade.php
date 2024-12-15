<table style="height: 650px; width: 100%; border-collapse: collapse;">
    <tr>
        <td style="text-align: center; vertical-align: middle; font-family: Helvetica;">
            <div style="margin: 10px auto; width: 500px; border-radius: 8px; border: 1px solid #c2c2c2;">
                <div style="text-align: center; padding: 20px 0 30px 0;">
                    <img width="150px" src="{{ asset('img/logos/'.$header_logo->image) }}" alt="">
                </div>
                <div style="text-align: center; background-color: #eb4747; padding: 10px 0;">
                    <img width="87px" src="{{ asset('img/logos/icon_mail.png') }}" alt="">
                </div>
                <div style="padding: 20px 30px 10px; color: #1e293b; text-align: justify;">
                    <span style="font-size: 36px;">Xác nhận đặt lại mật khẩu</span>
                    <p>Xin chào {{$customer->name}},</p>
                    <p>Vui lòng click vào nút dưới để đặt lại mật khẩu tài khoản mua hàng của bạn. Nếu bạn không phải
                        bạn đã yêu cầu hãy xóa email này.</p>
                    <div style="text-align: center; margin: 25px 0;">
                        <a style="display: inline-block; background: #eb4747; color: #fff; font-size: 16px; font-weight: 400; line-height: 1; letter-spacing: 1px; margin: 0; text-decoration: none; text-transform: none; padding: 12px 24px 12px 24px; border-radius: 4px;"
                            class="btn-verify" href='{{route("account.showResetPassword", $token)}}'>Đặt lại mật
                            khẩu</a>
                    </div>
                </div>
                <div style="padding-bottom: 15px;">
                    <div style="border-top: solid 1px #eb4747; font-size: 1px; margin: 0 auto; width: 80%;"></div>
                </div>
                <div style="text-align: center;">
                    <a href="#"><img width="32px" style="border-radius: 50%; margin: 0 10px;"
                            src="{{ asset('img/logos/icon_facebook.png') }}" alt=""></a>
                    <a href="#"><img width="32px" style="border-radius: 50%; margin: 0 10px;"
                            src="{{ asset('img/logos/icon_shopee.png') }}" alt=""></a>
                    <a href="#"><img width="32px" style="border-radius: 50%; margin: 0 10px;"
                            src="{{ asset('img/logos/icon_tiktok.png') }}" alt=""></a>
                    <a href="#"><img width="32px" style="border-radius: 50%; margin: 0 10px;"
                            src="{{ asset('img/logos/icon_phone.png') }}" alt=""></a>
                </div>
                <div style="text-align: center; margin-top: 15px;">
                    <span style="color: #444; font-size: 14px;">235 Hoàng Quốc Việt, Bắc Từ Liêm, Hà Nội</span>
                    <div style="margin: 15px 0 50px;">
                        <strong>|<a style="color: #000; text-decoration: none; margin: 0 3px; font-size: 15px;"
                                href="#">CooperStore</a>|<a
                                style="color: #000; text-decoration: none; margin: 0 3px; font-size: 15px;"
                                href="#">Chính sách bảo mật</a>|</strong>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>