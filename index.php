<?php include "PHP/header.php"; ?>
<?php include "PHP/nav.php"; ?>

<?php
    $showCaptchaError = "none";
    if(isset($_GET['error']) == "captcha_failed"){
        $showCaptchaError = "block";
    }
?>

<section class="hero">
    <div class="hero-btns">
        <button class="call-to-action open-modal-btn" data-modal="become-a-member-modal">Become a member</button>
        <button class="home-page-link" data-link="about-us">More Information</button>
    </div>

</section>

<section id="about-us">
    <h2 class="section-title">About us</h2>
    <p>
        <strong>Carpathia Investing Club (CIC)</strong> was founded in 2021, aiming at supporting individuals all over
        the world to better understand and apply investing principles. The club’s activity is based on a combined
        theoretical and practical approach, emphasizing the need of a proper market approach and analysis before placing
        any investment. CIC achieves its goal by organizing meetings that summarize market events and discuss the
        evolution of various companies and industries.
    </p>
    <p>
        On a monthly basis, CIC members pitch companies that satisfy
        internal selection and investing rules and include them or not in the portfolio recommendation. All companies
        that are pitched by CIC members are publicly available to other investors, as part of CIC mission of enhancing
        the trust and transparency in the investing process.
    </p>
</section>
<section id="strategy">
    <h2 class="section-title">Our strategy</h2>
    <p>
        <strong>Carpathia Investing Club (CIC)</strong> investing strategy is based on a bottom-up approach. CIC active
        members identify stocks that satisfy a set of selection rules (like price-to-earnings ratio, price-to-book
        ratio, market cap, intrinsic value etc.) and bring them to the attention of the CIC members. Each analyzed
        company can be found in the Portfolio section, with the title of recommendation. Based on ongoing analysis and
        in support of its members, CIC designs and tracks various portfolio configurations that can serve as models for
        real-time investing strategies.
    </p>
</section>
<section id="aum-section">
    <div class="counter-container">
        <div><span class="counter" data-target="120">0</span>k</div>
        <h3>Assets under <br> advisement</h3>
    </div>
    <div class="counter-container">
        <div><span class="counter" data-target="5">0</span></div>
        <h3>Members</h3>
    </div>
    <div class="counter-container">
        <div><span class="counter" data-target="1">0</span></div>
        <h3>Years <br> established</h3>
    </div>

</section>
<section id="contact">
    <h2 class="section-title">Contact Us</h2>
    <div class="contact-container">
        <div class="contact-logo">
            <div class="logo-details">
                <img class="contact-logo-img" src="img/Logo.png" alt="">
                <div class="contact-details">
                    <p><img src="img/logos/location.svg" alt="address" class="contact-icon">Retezat street, no. 2, Cluj-Napoca, Romania</p>
                    <!-- <p><img src="img/logos/phone.svg" alt="phone" class="contact-icon">(+4)0723 20 21 10</p> -->
                    <p><a href="invest@carpathiainvestingclub.org"><img src="img/logos/email.svg" alt="email"
                                class="contact-icon">invest@carpathiainvestingclub.org</a>
                    </p>

                </div>
            </div>
        </div>
        <form action="PHP/contact.php" method="POST" enctype="multipart/form-data">
            <p class="error captcha-failed-p" style="display: <?php echo $showCaptchaError ?>">Captcha failed. The form was not sent!</p>
            <!-- input needed for reCaptcha -->
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
            <div class="form-line">
                <div class="input-container half-width">
                    <label for="firstname" class="floating-label">First Name</label>
                    <input class="label-transform  required-field" type="text" name="firstname">
                </div>
                <div class="input-container half-width">
                    <label for="lastName" class="floating-label">Last Name</label>
                    <input class="label-transform  required-field" type="text" name="lastName">
                </div>
            </div>
            <div class="form-line">
                <div class="input-container half-width">
                    <label for="email" class="floating-label">Email</label>
                    <input class="label-transform  required-field" type="email" name="email">
                </div>
                <div class="input-container half-width">
                    <label for="phone" class="floating-label">Phone</label>
                    <input class="label-transform required-field" type="tel" name="phone">
                </div>
            </div>
            <div class="form-line">
                <div class="input-container">
                    <label for="message" class="floating-label">Message</label>
                    <textarea class="label-transform required-field" name="message" rows="5"></textarea>
                </div>
            </div>
            <p class="terms-checkbox">
                <input type="checkbox" name="terms_and_conditions" class="required-field">
                I have read and accept the privacy policy and the legal notice
            </p>

            <p class="all-fields-required-message">Please fill in all fields</p>
            <small class="g-recaptcha-branding">This site is protected by reCAPTCHA and the Google 
                <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> and
                <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.
            </small>
            
            <button type="submit" name="submit" class="submit-contact">SEND</button>
        </form>
    </div>
</section>

<!-- CAPTCHA -->
<script>
    function getReCaptcha() {
            grecaptcha.ready(function() {
            grecaptcha.execute("<?php echo $site_key ?>", {action: 'homepage'}).then(function(token) {
                document.getElementById("g-recaptcha-response").value = token;
            });
        });

    }       
    getReCaptcha();
    //Refesh token Every 110 Seconds
    setInterval(function(){
        getReCaptcha();
    }, 110*1000)
</script> 

<?php include "PHP/footer.php"; ?>