<?php echo $this->partial("partial/header");?>

        <section class="lap-content">
            <h2 class="lap-title">Register new account</h2>
            <div class="lap-account">
                <?php echo $Validation->errorString();?>
                <form action="<?php echo page_link("register/confirm");?>" method="POST" class="pure-form pure-form-aligned">
                    <fieldset>
                        <div class="pure-control-group">
                            <label for="lap-name">Name</label>
                            <input id="lap-name" name="name" type="text" placeholder="Input your name" class="pure-input-2-3" value="<?php echo $Validation->value("name");?>">
                        </div>
                        <div class="pure-control-group">
                            <label for="lap-email">Email</label>
                            <input id="lap-email" name="email" type="text" readonly class="pure-input-2-3" value="<?php echo prep_str($activate->email);?>">
                        </div>
                        <div class="pure-control-group">
                            <label for="lap-password">Password</label>
                            <input id="lap-password" name="password" type="password" placeholder="Input password" class="pure-input-2-3" value="<?php echo $Validation->value("password");?>">
                        </div>
                        <div class="pure-control-group">
                            <label for="lap-password-match">Password(Confirm)</label>
                            <input id="lap-password-match" name="password_match" type="password" placeholder="Input password" class="pure-input-2-3" value="<?php echo $Validation->value("password_match");?>">
                        </div>
                        <div class="lap-button-wrapper">
                            <input type="hidden" name="signin_token" value="<?php echo $register_token;?>">
                            <button type="submit" class="pure-button pure-button-primary">Confirm</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </section>

<?php echo $this->partial("partial/footer");?>
