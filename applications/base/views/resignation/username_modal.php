<script type="text/x-retriver-template" id="modify-username-modal">
<div class="lap-section lap-modal-frame lap-confirm-username">
    <h4 class="lap-section-caption">Confirm change username</h4>
    <div class="lap-modal-content">
        {{if userName}}
        <p>Register with username: <strong>{{userName}}</strong>, OK?</p>
        <form action="<?php echo page_link("signin/change_username");?>" method="post">
            <button type="submit" class="pure-button pure-warning lap-process" data-process="username">OK, regist my username</button>
            <input type="hidden" name="oauth_token" value="<?php echo prep_str($oauth_token);?>">
            <input type="hidden" name="social_id" value="<?php echo prep_str($social_id);?>">
            <input type="hidden" name="social_type" value="<?php echo prep_str($social_type);?>">
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
