<?php echo $this->partial("partial/header");?>
        <form class="lap-section emails pure-form">
            <h4 class="lap-section-caption">Emails</h4>
            <ul class="lap-emails">
                <?php foreach ( $emails as $email ):?>
                <li>
                    <i class="fa fa-envelope-o"></i>
                    <?php  echo prep_str($email->email);?>
                    <?php if ( $email->primary_use > 0 ):?><strong>(Primary)</strong><?php endif;?>
                    <?php if ( $email->is_activated ):?>
                    <span class="lap-email-status activated">
                        <i class="fa fa-check"></i>
                        Activated
                        <?php if ( $email->primary_use == 0 ):?>
                        &nbsp;|&nbsp;
                        <a href="#"><i class="fa fa-close"></i></a>
                        <?php endif;?>
                    </span>
                    <?php else:?>
                    <span class="lap-email-status waiting">
                        Activation waiting...
                    </span>
                    <?php endif;?>
                </li>
                <?php endforeach;?>
            </ul>
            <fieldset>
                <input class="pure-input" type="text" id="lap-account-emails" name="emails" value="" placeholder="Add new email">
                <button class="pure-button pure-button-primary" id="lap-email-activate">Start activation</button>
            </fieldset>
        </form>
        <form class="lap-section account pure-form pure-form-aligned">
            <h4 class="lap-section-caption">Password</h4>
            <fieldset>
                <div class="pure-control-group">
                    <label for="lap-account-password">Password</label>
                    <input class="pure-input" type="password" id="lap-account-password" name="password" value="">
                </div>
                <div class="pure-control-group">
                    <label for="lap-account-passwordconfirm">Password(Confirm)</label>
                    <input class="pure-input" type="password" id="lap-account-password-confirm" name="password_confirm" value=""><br>
                </div>
                <div class="pure-controls">
                    <span class="warning"><i class="fa fa-exclamation-circle"></i>Password not changed when password field is empty</span>
                    <button class="pure-button pure-button-primary" id="lap-change-password">Confirm</button>
                </div>
            </fieldset>
        </form>
        <form class="lap-section username lap-warning pure-form">
            <h4 class="lap-section-caption">UserName</h4>
            <fieldset>
                <p class="notification"><i class="fa fa-warning"></i>If username changed, your pin URL also changed.</p>
                <input class="pure-input lap-input-username" name="username" id="lap-account-username" type="text" value="<?php echo prep_str($user->name);?>">
                <button class="pure-button pure-danger" id="lap-change-username">Change</button>
            </fieldset>
        </form>
        <form class="lap-section username lap-danger pure-form">
            <h4 class="lap-section-caption">Delete Account</h4>
            <fieldset>
                <p class="notification"><i class="fa fa-warning"></i>If delete account, your all pin data will be lost.</p>
                <button class="pure-button pure-danger" id="lap-delete-account">Delete Account</button>
            </fieldset>
        </form>
<?php echo $this->partial("partial/footer");?>
