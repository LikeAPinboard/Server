<?php echo $this->partial("partial/header");?>

        <section class="lap-content">
            <h2 class="lap-title">Registration Error!</h2>
            <div class="lap-account">
                <p>Sorry, registration has not completed. try later...<p>
                <p>
                    <a href="<?php echo page_link("signin");?>" class="pure-button lap-account-button">
                        <i class="fa fa-caret-right"></i>
                        Back to Sign in page
                    </a>
                </p>
            </div>
        </section>

<?php echo $this->partial("partial/footer");?>
