<?php include "PHP/header.php"; ?>
<?php include "PHP/nav.php"; ?>

<section class="hero">
    <div class="hero-btns">
        <button class="call-to-action">Become a member</button>
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
<section id="strategy" class="strategy">
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
<section id="contact">
    <h2 class="section-title">Contact Us</h2>
    <div class="contact-container">
    <div class="contact-logo">
        <img src="img/Logo.png" alt="">
    </div>
    <form action="PHP/contact.php" method="POST" enctype="multipart/form-data">
        <div class="form-line">
            <div class="input-container half-width">
                <label for="name" class="floating-label">Name</label>
                <input class="label-transform  required-field" type="text" name="name" >
            </div>
            <div class="input-container half-width">
                <label for="lastName" class="floating-label">Last Name</label>
                <input class="label-transform  required-field" type="text" name="lastName" >
            </div>
        </div>
        <div class="form-line">
            <div class="input-container half-width">
                <label for="email" class="floating-label">Email</label>
                <input class="label-transform  required-field" type="email" name="email" >
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
        <button type="submit" name="submit" class="submit-contact">SEND</button>
    </form>
    </div>
</section>

<?php include "PHP/footer.php"; ?>