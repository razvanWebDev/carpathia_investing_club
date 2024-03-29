<div class="requests-modal">
    <img src="img/icon-close.svg" alt="close" class="close-modal-btn">
    <h2 class="section-title">Become a Member</h2>
    <form action="PHP/requests.php" method="POST" enctype="multipart/form-data">
        <input id="request-type" name="request_type" type="hidden" value="Become a member">
        <div class="form-line">
            <div class="input-container half-width">
                <label for="firstname" class="floating-label">First Name*</label>
                <input class="label-transform  required-field" type="text" name="firstname">
            </div>
            <div class="input-container half-width">
                <label for="lastname" class="floating-label">Last Name*</label>
                <input class="label-transform  required-field" type="text" name="lastname">
            </div>
        </div>
        <div class="form-line">
            <div class="input-container half-width">
                <label for="email" class="floating-label">Email*</label>
                <input class="label-transform  required-field" type="email" name="email">
            </div>
            <div class="input-container half-width">
                <label for="phone" class="floating-label">Phone</label>
                <input class="label-transform" type="tel" name="phone">
            </div>
        </div>
        <div class="form-line">
            <div class="input-container half-width">
                <label for="age" min="0" class="floating-label">Age</label>
                <input class="label-transform" type="number" name="age">
            </div>
            <div class="input-container half-width">
                <div class="custom-select-wrapper">
                    <div class="custom-select">
                        <div class="custom-select__trigger" name="custom-select__trigger" value="Investing Experience">
                            <span>
                                Investing Experience
                            </span>
                            <div class="arrow"></div>
                        </div>
                        <div class="custom-options">
                            <!-- needed to sent php data, value set in JS -->
                            <input name="investing_experience" class="select-value-input" type="hidden" value="">

                            <span class="custom-option selected" data-value="">
                                Investing Experience
                            </span>
                            <span class="custom-option" data-value="Beginner">
                                Beginner
                            </span>
                            <span class="custom-option" data-value="Intermediate">
                                Intermediate
                            </span>
                            <span class="custom-option" data-value="Advanced">
                                Advanced
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-line">
            <div class="input-container">
                <label for="message" class="floating-label">Message</label>
                <textarea class="label-transform" name="message" rows="5"></textarea>
            </div>

        </div>
        <p class="terms-checkbox">
            <input type="checkbox" name="terms_and_conditions" class="required-field">
            I have read and accept the <a href="terms-and-conditions" target="_blank">Terms and Conditions</a>
        </p>

        <p class="all-fields-required-message">Please fill in all fields</p>
        <button type="submit" name="submit" class="submit-request-form">SEND</button>
    </form>
</div>