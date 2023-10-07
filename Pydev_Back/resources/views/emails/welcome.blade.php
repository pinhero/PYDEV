{{-- <!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="date=no" />
    <meta name="format-detection" content="address=no" />
    <meta name="format-detection" content="telephone=no" />
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700italic,700' rel='stylesheet' type='text/css' />
    <title>Bienvenue cher expert</title>


    <style type="text/css" media="screen">
        @import url('https://fonts.googleapis.com/css?family=Varela+Round');

* {
  margin: 0;
  padding: 0;
  font-family: Varela Round, 'Segoe UI', 'Arial', 'san serif';
}

img {
  display: inline-block;
}
.container {
  max-width: 500px;
  margin: 20px auto;
  border-radius: 4px;
  border: 1px solid rgba(0, 0, 0, .1);
  // border-top: 3px solid #016FB9;
  min-height: 100px;
  position: relative;
  &::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(to right, #0267C1, #D65108);
  }
}

.logo {
  display: flex;
  margin: 30px auto 0;
  align-items: center;
  justify-content: center;
  // padding: 20px;
  a {
    display: block;
    width: 30px;
    height: 30px;
    // overflow: hidden;
  }
  img {
    width: 180px;
  }
  .c-name {
    display: inline-block;
    font-weight: 600;
  }
}

.thumbs {
  width: 100px;
  margin: auto;
  height: 136px;
  img {
    width: 100%;
  }
}

.illustration {
  width: 100%;
  text-align: center;
  box-shadow: 0 10px 20px -5px rgba(0, 0, 0, .05);
  border-radius: 0 0 50% 50% / 1%;
  text-align: center;
}

.illustration img {
  width: 70%;
  margin: 50px auto;
}

.separator {
  display: block;
  height: 3px;
  width: 70%;
  margin: 10px auto;
  background-color: rgba(0, 0, 0, .05);
  border-radius: 10px;
  position: relative;
  overflow: hidden;
  &::before, &::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 33%;
    border-radius: inherit;
    opacity: .05;
  }
  &::before {
    left: 0;
    background: #EFA00B;
  }
  &::after {
    left: initial;
    right: 0;
    background: #D65108;
  }
}

.hgroup {
  text-align: center;
  padding: 50px 30px 30px;
}

.name {
  display: block;
  // text-transform: uppercase;
  // margin-bottom: 5px;
  color: #0267C1;
  font-weight: 600;
  font-size: 1.1rem;
}

.hgroup h1 {
  font-size: 20px;
  font-weight: 600;
  color: #333;
}

.hgroup h2 {
  font-size: 19px;
}

.hgroup p {
  font-size: 15px;
  color: slategrey;
  margin-top: 15px;
  text-align: justify;
  line-height: 25px;
}

.items {
  padding: 30px;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
}

.item {
  margin-bottom: 10px;
  text-align: center;
  width: 100%;
  margin: 0 auto 50px;
}


.item .icon {
    margin-bottom: 10px;
}

.item .icon img {
  width: 60px;
}

.item .title {
  margin-bottom: 5px;
  font-size: 16px;
  font-weight: 600;
}

.item .subtitle {
  font-size: 13px;
  color: slategrey;
  padding: 1rem;
}

.button-wrap {
  text-align: center;
  padding: 2rem;
}

button.explore {
  padding: 15px 25px;
  font: inherit;
  background: linear-gradient(to right, #0267C1, #0280EF);
  border-radius: 50px;
  border: 0;
  color: #fff;
  margin: auto;
  display: inline-block;
  transition: all .2s ease-in-out;
  cursor: pointer;
  box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
}

button.explore:hover {
  transform: translateY(-5px);
    box-shadow: 0 15px 10px -7px rgba(0, 0, 0, .1);
}


footer {
  font-size: 12px;
  color: slategrey;
  text-align: center;
  padding: 30px;
}

.rad {
  margin: 0!important;
  text-align: center!important;
  font-size: 18px!important;
}

.raised {
  font-size: 16px;
  color: #777;
  display: block;
  color: steelblue;
}
    </style>
</head>

<body class="body">
<div class="container">
  <div class="logo"><img src="https://placeholder.com/wp-content/uploads/2018/10/placeholder.com-logo3.png" alt="cc-logo" border="0">
  </div>
  <div class="illustration">
    <div class="hgroup">
      <span class="name">Hello, {{ $user->firstname }} {{ $user->lastname }}</span>
      <h1>Thank you for Signing Up</h1>
      <div class="thumbs">
        <a href="https://imgbb.com/"><img src="https://i.ibb.co/2g7tS2d/good.png" alt="good" border="0"></a>
      </div>
      <p class="rad">Rad stuff is here</p>
    </div>
  </div>

  <div class="hgroup">
    <p>
      Placeholder aims at solving all lending problems in africa, we built a platform to support the lenders community with high quality, cost concious assets like: the web plug in, mobile app, chat bot, sophiscated credit analysis, bank statement analysis and more. And these products live on a site packed with the best practice and shared knowledge resources from our team to you.
      <br><br>
      <p>
        <span class="raised">Hold up, there's more!</span>
        A 7 days simulation trial, your trial starts now.
      </p>
      <p>If you have any questions, kindly reach out to our team on support@placeholder.com.</p>

      <p>Have an AWESOME day! <br>
        Brought to you by your friends at Placeholder.
      </p>
    </p>

  </div>
  <div class="hgroup">
    <h2>What we offer</h2>
  </div>
  <div class="items">
    <div class="item">
      <div class="icon">
        <img src="https://i.ibb.co/tHZQHTB/desktop.png" alt="desktop" border="0">
      </div>
      <div class="title">Advance Backend</div>
      <div class="subtitle">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eveniet sed culpa cupiditate?
      </div>
    </div>
    <div class="item">
      <div class="icon">
        <img src="https://i.ibb.co/zSD3NkX/smartphone.png" alt="smartphone" border="0">
      </div>
      <div class="title">Mobile Platform</div>
      <div class="subtitle">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eveniet sed culpa cupiditate?
      </div>
    </div>
  </div>
  <div class="button-wrap">
    <button class="explore">
      Explore
    </button>
  </div>
  <footer>
    Brand Name Inc © 2019
    <br>
    Somewhere in earth.
    <br>
    Tel: 00 1 460 5416
  </footer>
</div>
</body>

</html> --}}
<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
  <!--[if mso]>
    <xml><o:officedocumentsettings><o:pixelsperinch>96</o:pixelsperinch></o:officedocumentsettings></xml>
  <![endif]-->
    <title>Welcome to PixInvent 👋</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700" rel="stylesheet" media="screen">
    <style>
.hover-underline:hover {
  text-decoration: underline !important;
}
@media (max-width: 600px) {
  .sm-w-full {
    width: 100% !important;
  }
  .sm-px-24 {
    padding-left: 24px !important;
    padding-right: 24px !important;
  }
  .sm-py-32 {
    padding-top: 32px !important;
    padding-bottom: 32px !important;
  }
  .sm-leading-32 {
    line-height: 32px !important;
  }
}
</style>
</head>
<body style="margin: 0; width: 100%; padding: 0; word-break: break-word; -webkit-font-smoothing: antialiased; background-color: #eceff1;">
    <div style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; display: none;">We are please to welcome you to PixInvent</div>
  <div role="article" aria-roledescription="email" aria-label="Welcome to PixInvent 👋" lang="en" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
    <table style="width: 100%; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center" style="mso-line-height-rule: exactly; background-color: #eceff1; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;">
          <table class="sm-w-full" style="width: 600px;" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
  <td class="sm-py-32 sm-px-24" style="mso-line-height-rule: exactly; padding: 48px; text-align: center; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;">
    <a href="https://1.envato.market/vuexy_admin" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
      <img src="images/logo.png" width="155" alt="Vuexy Admin" style="max-width: 100%; vertical-align: middle; line-height: 100%; border: 0;">
    </a>
  </td>
</tr>
              <tr>
                <td align="center" class="sm-px-24" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                  <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                      <td class="sm-px-24" style="mso-line-height-rule: exactly; border-radius: 4px; background-color: #ffffff; padding: 48px; text-align: left; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 16px; line-height: 24px; color: #626262;">
                        <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 20px; font-weight: 600;">Hey</p>
                        <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 0; font-size: 24px; font-weight: 700; color: #ff5850;">John Doe!</p>
                        <p class="sm-leading-32" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-bottom: 24px; font-size: 24px; font-weight: 600; color: #263238;">
                          🏆 Best selling #1 admin template ever!
                        </p>
                        <a href="https://1.envato.market/vuexy_admin" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                          <img src="images/item.jpg" width="500" alt="Vuexy Admin" style="max-width: 100%; vertical-align: middle; line-height: 100%; border: 0;">
                        </a>
                        <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-top: 24px; margin-bottom: 24px;">
                          <span style="font-weight: 600;">Vuexy</span>
                          is the most developer friendly & highly customisable VueJS + HTML Admin Dashboard Template
                          based on Vue CLI, Vuex & Vuexy component framework. 🤩
                        </p>
                        <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 18px; font-weight: 500;">How can you use Vuexy for your next project?</p>
                        <ul style="margin-bottom: 24px;">
                          <li>
                            Vuexy Admin provides you getting start pages 🚀 with different layouts, use the layout as
                            per your custom requirements and just change the branding, menu & content.
                          </li>
                          <li>
                            Every components in Vuexy Admin are decoupled 🛠, it means use use only components you
                            actually need! Remove unnecessary and extra code easily just by excluding the path to
                            specific SCSS, JS file. 🤟🏻
                          </li>
                        </ul>
                        <table cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td style="mso-line-height-rule: exactly; mso-padding-alt: 16px 24px; border-radius: 4px; background-color: #7367f0; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;">
                              <a href="https://example.com" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; display: block; padding-left: 24px; padding-right: 24px; padding-top: 16px; padding-bottom: 16px; font-size: 16px; font-weight: 600; line-height: 100%; color: #ffffff; text-decoration: none;">Browse PixInvent &rarr;</a>
                            </td>
                          </tr>
                        </table>
                        <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
  <tr>
    <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; padding-top: 32px; padding-bottom: 32px;">
      <div style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; height: 1px; background-color: #eceff1; line-height: 1px;">&zwnj;</div>
    </td>
  </tr>
</table>
<p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-bottom: 16px;">
  Not sure why you received this email? Please
  <a href="mailto:support@example.com" class="hover-underline" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #7367f0; text-decoration: none;">let us know</a>.
</p>
<p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-bottom: 16px;">Thanks, <br>The PixInvent Team</p>
                      </td>
                    </tr>
                    <tr>
  <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; height: 20px;"></td>
</tr>
<tr>
  <td style="mso-line-height-rule: exactly; padding-left: 48px; padding-right: 48px; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 14px; color: #eceff1;">
    <p align="center" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 16px; cursor: default;">
      <a href="https://www.facebook.com/pixinvents" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #263238; text-decoration: none;"><img src="images/facebook.png" width="17" alt="Facebook" style="max-width: 100%; vertical-align: middle; line-height: 100%; border: 0; margin-right: 12px;"></a>
      &bull;
      <a href="https://twitter.com/pixinvents" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #263238; text-decoration: none;"><img src="images/twitter.png" width="17" alt="Twitter" style="max-width: 100%; vertical-align: middle; line-height: 100%; border: 0; margin-right: 12px;"></a>
      &bull;
      <a href="https://www.instagram.com/pixinvents" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #263238; text-decoration: none;"><img src="images/instagram.png" width="17" alt="Instagram" style="max-width: 100%; vertical-align: middle; line-height: 100%; border: 0; margin-right: 12px;"></a>
    </p>
    <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #263238;">
      Use of our service and website is subject to our
      <a href="https://pixinvent.com/" class="hover-underline" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #7367f0; text-decoration: none;">Terms of Use</a> and
      <a href="https://pixinvent.com/" class="hover-underline" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #7367f0; text-decoration: none;">Privacy Policy</a>.
    </p>
  </td>
</tr>
<tr>
  <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; height: 16px;"></td>
</tr>
                  </table>
                </td>
              </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>

