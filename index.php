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
        <button class="call-to-action open-modal-btn" data-modal="requests-modal" data-title="Become a Member">Become a member</button>
        <button class="home-page-link" data-link="about-us">More Information</button>
    </div>

</section>

<section id="about-us">
    <h2 class="section-title">About us</h2>
    <p>
        Carpathia Investing Club (CIC) was founded in 2021. The club is dedicated to support
        individuals all around the world to better understand and apply investing principles. <strong>For first time
            investors</strong>, the club’s activity is based on a combined educational and practical approach that
        emphasizes the need of a proper understanding of the basic principles that govern the stock market before
        starting to invest. <strong>For more experienced investors</strong>, the club works as a forum that offers the
        opportunity to discuss and analyze various investment opportunities in stocks and long-term investment
        strategies.
    </p>
    <p>
        CIC’s internal chat platform is used by its members to communicate, interact, exchange and debate investing
        ideas in an easy way, no matter the city or country where they live in. Moreover, the chat is used by the
        members to discuss and pitch companies that satisfy CIC’s selection and investing rules. All pitched companies
        are listed in the Portfolio section of the site.
    </p>
</section>
<section id="strategy">
    <h2 class="section-title">Our strategy</h2>
    <p>
        Carpathia Investing Club’s (CIC) investing strategy is based on a bottom-up approach. When CIC members identify
        a stock that satisfies a certain set of selection rules (like price-to-earnings ratio, price-to-book ratio,
        market cap or intrinsic value), the stock gets listed in the internal forum.
    </p>
    <p>
        At this point, CIC members start to gather relevant information, realize first hand analysis and express pro and
        cons arguments in favor or against the company being reviewed. At the end of this process, CIC members get a
        better understanding of the potential risk and reward involved by the analyzed companies.
    </p>
</section>
<section id="mission">
    <h2 class="section-title">Our mission</h2>
    <p>
        We believe that investing should and can be done by everyone! We know that making the first investment is not
        easy but that is why we are here! Statistically, 90% of the investors lose 90% of their money in the first 90
        days. Why to be one of them? Our mission is to support individuals to make the first steps into the stock
        market, to have a clear investing goal and strategy and to avoid some of the most common mistakes made by young
        investors (use of leverage, intensive trading, market timing, taking unnecessary risk, etc). We work on daily
        basis to extend our community and promote the values that lay the foundation of our club: <strong>financial
            education, portfolio diversification, long-term investments</strong> and <strong>high-quality
            stocks</strong>.
    </p>
</section>
<section id="become-a-member">
    <h2 class="section-title">How to Become a Member of Our Community?</h2>
    <p>
        As the membership in our Club is free of charge, all we ask from you is your willingness to educate yourself in
        becoming a long term successful investor. Based on our experience, the success of an investing community comes
        from a basic set of investing principles and rules that are shared by its members. Thus, before becoming a
        member, we want to help our members master some key concepts like price-to-earnings, price-to-book, intrinsic
        value, portfolio diversification, income or growth stocks. In order to do this, you can choose one of the two
        investor roadmaps designed for new members.
    </p>
</section>
<section id="membership-benefits">
    <h2 class="section-title">Benefits of Membership</h2>
    <p>Part of an Investors Network</p>
    <p>Knowledge Sharing among Members</p>
    <p>Access to the Private Chat</p>
    <p>Access to Webinars</p>
    <p>Access to Workshops</p>
    <p>Access to Educational Tools</p>
    <p>1-to-1 talks for more in detail information and guidance</p>
</section>
<section id="members-path">
    <h2 class="section-title">Carpathia Investing Club Investor’s Path</h2>
    <div class="path-cards-container">
        <div class="path-card">
            <div class="box">
               <div class="box-content">
                    <h2>CIC</h2>
                    <h3>Basic Investing Roadmap<br><span>2-3 months</span></h3>
                    <ul>
                        <li>Self-study and self-reading</li>
                        <li>Several short books and articles to read and discuss</li>
                        <li>2 tutoring sessions, 1-to-1</li>
                        <li>ETFs and Stocks Analysis </li>
                        <li>Investing goals </li>
                    </ul>
                    <button class="open-modal-btn" data-modal="requests-modal" data-title="Book Basic Investing Roadmap">BOOK NOW!</button>
               </div>
            </div>
        </div>

        <div class="path-card">
           <div class="box">
                <div class="box-content">
                    <h2>CIC</h2>
                    <h3>Intensive Investing Roadmap<br><span>2 days</span></h3>
                    <ul>
                        <li>2 intensive coaching sessions</li>
                        <li>Analysis of investing styles </li>
                        <li>How to build a diversified portfolio</li>
                        <li>Medium and Long-Term Investing Goals </li>
                        <li>Dollar Cost Averaging and Discounted Cash Flow Model</li>
                        <li>Income or Growth Portfolios? How to balance a portfolio</li>
                        <li>When to Buy, when to Sell a Stock </li>
                    </ul>
                    <button class="open-modal-btn" data-modal="requests-modal" data-title="Book Intensive Investing Roadmap">BOOK NOW!</button>
                </div>
           </div>
        </div>
     
    </div>
</section>
<section id="aum-section">
    <div class="counter-container">
        <?php
            $query = "SELECT * FROM assets_under_advisement WHERE id=1";
            $select_users = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_users)) {
                $amount = $row['amount'];
            }
        ?>
        <div><span class="counter" data-target="<?php echo $amount ?>">0</span>k</div>
        <h3>Assets under <br> advisement</h3>
    </div>
    <div class="counter-container">
        <?php
        $query = "SELECT * FROM members";
        $result = mysqli_query($connection, $query);
        $num_members = mysqli_num_rows($result);
    ?>
        <div><span class="counter" data-target="<?php echo $num_members ?>">0</span></div>
        <h3>Members</h3>
    </div>
    <div class="counter-container">
        <?php
            $years_established = date('Y') - 2020;
        ?>
        <div><span class="counter" data-target="<?php echo $years_established ?>">0</span></div>
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
                    <p><img src="img/logos/location.svg" alt="address" class="contact-icon">Retezat street, no. 2,
                        Cluj-Napoca, Romania</p>
                    <!-- <p><img src="img/logos/phone.svg" alt="phone" class="contact-icon">(+4)0723 20 21 10</p> -->
                    <p><a href="mailto: invest@carpathiainvestingclub.org"><img src="img/logos/email.svg" alt="email"
                                class="contact-icon">invest@carpathiainvestingclub.org</a>
                    </p>

                </div>
            </div>
        </div>
        <form action="PHP/contact.php" method="POST" enctype="multipart/form-data">
            <p class="error captcha-failed-p" style="display: <?php echo $showCaptchaError ?>">Captcha failed. The form
                was not sent!</p>
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
                I have read and accept the <a href="terms-and-conditions">Terms and Conditions</a>
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
        grecaptcha.ready(function () {
            grecaptcha.execute("<?php echo $site_key ?>", { action: 'homepage' }).then(function (token) {
                document.getElementById("g-recaptcha-response").value = token;
            });
        });

    }
    getReCaptcha();
    //Refesh token Every 110 Seconds
    setInterval(function () {
        getReCaptcha();
    }, 110 * 1000)
</script>

<?php include "PHP/footer.php"; ?>