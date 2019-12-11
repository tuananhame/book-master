<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/userform.css') }}">
    <title>User Setting</title>
</head>
<body>
        <div class="main-content printed">
        <form id="update_profile" action="{!! URL::route('user.update') !!}" method="post">
                <div class="header"> <span>Cập nhật thông tin cá nhân</span><span>Your Conference Badge</span></div>
                <div class="id__wrapper">
                  <div class="deco"></div>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <label class="your-face" id="image-form" for="image-input">
                    <input type="file" id="image-input"/>
                    <div class="image-persuader">Tải lên ảnh đại diện</div><img id="imager" src="#" alt="Your Image Here"/>
                  </label>
                  <div class="name">
                    <label>Tên đầy đủ</label>
                    <input name="name" type="text" class="full"/>
                  </div>
                  <div class="job">
                    <label>Tuổi</label>
                    <input name="age" type="text" class="full"/>
                  </div>
                  <div class="country">
                    <label>Địa chỉ</label>
                    <input name="address" type="text" class="full"/>
                  </div>
                  <div class="twitter">
                    <label>Số điện thoại</label>
                    <input name="phone" type="number" class="full" value="0"/>
                  </div>
                  <div class="codepen">
                    <label>Địa chỉ gmail</label>
                    <input name="email" type="email" class="full" value="@"/>
                  </div>
                  <div class="blood">
                    <label>Bạn tới đây để?</label>
                    <div class="checkbox__wrapper">
                      <div class="checkbox">
                        <input id="borrower" type="checkbox" value="1" checked="checked"/>
                        <label class="label-check" for="borrower">Người mượn sách</label>
                      </div>
                      <div class="checkbox">
                        <input id="advertisement" type="checkbox" value="2"/>
                        <label class="label-check" for="advertisement">Muốn quảng cáo sách</label>
                      </div>
                      <div class="checkbox">
                        <input id="friend" type="checkbox" value="3"/>
                        <label class="label-check" for="friend">Giao lưu kết bạn    </label>
                      </div>
                      <div class="checkbox">
                        <input id="other" type="checkbox" value="4"/>
                        <label class="label-check" for="other">Khác</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
</form>
              <aside class="context">
                <div class="explanation">
                  <div class="js-switch">Cập nhật</div>
                    </div>
              </aside>
              <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
              <script type="text/javascript" src="{{ asset('js/userform.js') }}" ></script>
              <script type="text/javascript" >
              	$(document).ready(function() {
                  $('.js-switch').click(() => {
                    $("#update_profile").submit();
                  });
                });
              </script>
</body>
</html>