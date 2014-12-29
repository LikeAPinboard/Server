<?php echo $this->partial("partial/header");?>

        <section class="lap-content">
            <h2 class="lap-title">Confirm your account</h2>
            <div class="lap-account">
                <form action="<?php echo page_link("register/regist");?>" method="POST" class="pure-form pure-form-aligned">
                    <fieldset>
                        <div class="pure-control-group">
                            <label for="lap-name">Name</label>
                            <input id="lap-name" name="name" type="text" readonly class="pure-input-2-3" value="<?php echo prep_str($Validation->value("name"));?>">
                        </div>
                        <div class="pure-control-group">
                            <label for="lap-email">Email</label>
                            <input id="lap-email" name="email" type="text" readonly class="pure-input-2-3" value="<?php echo prep_str($activate->email);?>">
                        </div>
                        <div class="pure-control-group">
                            <label for="lap-password">Password</label>
                            <input id="lap-password" name="password" type="password" readonly class="pure-input-2-3" value="<?php echo prep_str($Validation->value("password"));?>">
                        </div>
                        <div class="lap-button-wrapper">
                            <input type="hidden" name="signin_token" value="<?php echo $register_token;?>">
                            <input type="hidden" name="password_match" value="<?php echo prep_str($Validation->value("password_match"));?>">
                            <button class="pure-button lap-back-button" data-backurl="<?php echo page_link("register/index");?>">Back to input</button>&nbsp;&nbsp;
                            <button type="submit" class="pure-button pure-button-primary">Regist</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </section>

<?php echo $this->partial("partial/footer");?>
