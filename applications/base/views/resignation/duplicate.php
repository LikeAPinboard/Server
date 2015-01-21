<?php echo $this->partial("partial/header");?>

        <form class="lap-section account pure-form pure-form-aligned">
            <h4 class="lap-section-caption">Username duplicated</h4>
            <fieldset>
            <p>Your name <strong>"<?php echo prep_str($social_name);?>"</strong> is already exists. Please input other name.</p>
                <div class="pure-control-group">
                    <label for="lap-account-username">username</label>
                    <input class="pure-input" type="text" id="lap-account-username" name="username" value="">
                </div>
                <div class="pure-controls">
                    <button class="pure-button pure-button-primary" id="lap-change-username">Confirm</button>
                </div>
            </fieldset>
        </form>

<?php echo $this->partial("partial/footer");?>
