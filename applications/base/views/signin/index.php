<?php echo $this->partial("partial/header");?>

        <section class="lap-content">
            <h2 class="lap-title">Sign in</h2>
            <div class="lap-account pure-g">
                <div class="pure-u-1-3">
                    <a href="<?php echo page_link("signin/twitter");?>" class="pure-button lap-account-button lap-account-twitter">
                        <i class="fa fa-twitter"></i>
                        Sign in with Twitter
                    </a>
                </div>
                <div class="pure-u-1-3">
                    <a href="<?php echo page_link("signin/github");?>" class="pure-button lap-account-button lap-account-github">
                        <i class="fa fa-github-alt"></i>
                        Sign in with Github
                    </a>
                </div>
                <div class="pure-u-1-3">
                    <a href="<?php echo page_link("signin/facebook");?>" class="pure-button lap-account-button lap-account-facebook">
                        <i class="fa fa-facebook-square"></i>
                        Sign in with Facebook
                    </a>
                </div>
            </div>
            <h2 class="lap-title">Sign in with registered account</h2>
            <div class="lap-account">
                <?php if ( isset($signin_error) ):?>
                <div class="lap-notification error">Signin error.</div>
                <?php endif;?>
                <?php echo $Validation->errorString();?>
                <form action="<?php echo page_link("signin/account");?>" method="POST" class="pure-form pure-form-aligned">
                    <fieldset>
                        <div class="pure-control-group">
                            <label for="lap-email">Email</label>
                            <input id="lap-email" name="email" type="email" placeholder="Input registered email address" class="pure-input-2-3" value="<?php echo $Validation->value("email");?>">
                        </div>
                        <div class="pure-control-group">
                            <label for="lap-password">Password</label>
                            <input id="lap-password" name="password" type="password" placeholder="Input registered password" class="pure-input-2-3" value="<?php echo $Validation->value("password");?>">
                        </div>
                        <div class="lap-button-wrapper">
                            <input type="hidden" name="signin_token" value="<?php echo $signin_token;?>">
                            <button type="submit" class="pure-button pure-button-primary">Sign in</button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <h2 class="lap-title">Do you need a new account?</h2>
            <div class="lap-account">
                <form action="<?php echo page_link("signin");?>" method="POST" class="pure-form pure-form-aligned" id="js-activate-form">
                    <fieldset>
                        <div class="pure-control-group">
                            <label for="lap-email">Email</label>
                            <input id="lap-email" name="email" type="email" placeholder="Input your email address" class="pure-input-2-3" value="">
                        </div>
                        <div class="lap-button-wrapper">
                            <button type="submit" class="pure-button pure-button-primary" id="js-activate">Activate</button>
                        </div>
                    </fieldset>
                </form>
            </div>
                
        </section>

<?php echo $this->partial("partial/footer");?>
