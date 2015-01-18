<script type="text/x-retriver-template" id="delete-account-modal">
<div class="lap-section lap-modal-frame lap-danger lap-confirm-delete">
    <h4 class="lap-section-caption">Confirm delete account</h4>
    <div class="lap-modal-content">
        <p class="notification">Are you sure?</p>
        <form action="<?php echo page_link("my/delete_account");?>" method="post">
            <button type="submit" class="pure-button pure-danger lap-process" data-process="delete">OK, Delete my account</button>
            <input type="hidden" name="lap_account_delete_token" value="<?php echo $account_token;?>">
        </form>
    </div>
    <a href="#" class="lap-modal-close" data-close="1">
        <i class="fa fa-close"></i>
    </a>
</div>
</script>
<script type="text/x-retriver-template" id="email-confirm-modal">
<div class="lap-section lap-modal-frame lap-confirm-email">
    <h4 class="lap-section-caption">Confirm email activation</h4>
    <div class="lap-modal-content">
        {{if email}}
        <p>Do you send to email below?</p>
        <pre class="square">{{email}}</pre>
        <form action="<?php echo page_link("my/email");?>" method="post">
            <button type="submit" class="pure-button pure-button-primary lap-process" data-process="email">Receive activation mail</button>
            <input type="hidden" name="lap_new_email_token" value="<?php echo $account_token;?>">
            <input type="hidden" name="email" value="{{email}}">
        </form>
        {{else}}
        <p class="error">Email must not empty!</p>
        <button class="pure-button" data-close="1">Close</button>
        {{/if}}
    </div>
    <a href="#" class="lap-modal-close" data-close="1">
        <i class="fa fa-close"></i>
    </a>
</div>
</script>
<script type="text/x-retriver-template" id="password-confirm-modal">
<div class="lap-section lap-modal-frame lap-confirm-password">
    <h4 class="lap-section-caption">Confirm change password</h4>
    <div class="lap-modal-content">
        {{if password}}
            {{if password == passwordConfirm}}
            <p>Change password?</p>
            <form action="<?php echo page_link("my/password");?>" method="post">
                <button type="submit" class="pure-button pure-button-primary lap-process" data-process="password">OK, chnage my password</button>
                <input type="hidden" name="lap_username_change_token" value="<?php echo $account_token;?>">
                <input type="hidden" name="password" value="{{password}}">
            </form>
            {{else}}
            <p class="error">Password is not match with confirm!</p>
            <button class="pure-button" data-close="1">Close</button>
            {{/if}}
        {{else}}
        <p class="error">Password is empty!</p>
        <button class="pure-button" data-close="1">Close</button>
        {{/if}}
    </div>
    <a href="#" class="lap-modal-close" data-close="1">
        <i class="fa fa-close"></i>
    </a>
</div>
</script>
<script type="text/x-retriver-template" id="modify-username-modal">
<div class="lap-section lap-modal-frame lap-warning lap-confirm-username">
    <h4 class="lap-section-caption">Confirm change username</h4>
    <div class="lap-modal-content">
        {{if userName}}
        <p class="notification">Will change your pin URL</p>
        <p><?php echo page_link("u:{$user->name}");?></p>
        <p>to</p>
        <p><?php echo page_link("u:{{userName}}");?></p>
        <form action="<?php echo page_link("my/change_username");?>" method="post">
            <button type="submit" class="pure-button pure-warning lap-process" data-process="username">OK, Change my username</button>
            <input type="hidden" name="lap_username_change_token" value="<?php echo $account_token;?>">
            <input type="hidden" name="username" value="{{userName}}">
        </form>
        {{else}}
        <p class="error">username is empty!</p>
        <button class="pure-button" data-close="1">Close</button>
        {{/if}}
    </div>
    <a href="#" class="lap-modal-close" data-close="1">
        <i class="fa fa-close"></i>
    </a>
</div>
</script>
