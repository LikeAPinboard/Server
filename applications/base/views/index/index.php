<?php echo $this->partial("partial/header");?>
        <?php if ( $auth_result === 0 ):?>
            <div class="lap-auth-result auth-success">
                <p>Authenticate success.</p>
            </div>
        <?php elseif ( $auth_result === 1 ):?>
            <div class="lap-auth-result auth-error">
                <p>Authenticate error.</p>
            </div>
        <?php endif;?>
        <section class="lap-content">
            <h2 class="lap-title">Your Accout Status</h2>
            <section class="lap-token">
                <h3>This server URL ( for Chrome Extension )</h3>
                <p class="lap-info-value">
                <input type="text" value="<?php echo prep_str(get_config("api_server_url"));?>" readonly>
                </p>
                <h3>Your token ( for Chrome Extension )</h3>
                <p class="lap-info-value">
                <input type="text" value="<?php echo prep_str($user->token);?>" readonly>
                </p>
                <h3>Download Alfred .rc file ( for Alfred Worflow )</h3>
                <a href="<?php echo page_link("download");?>" class="pure-button button-primary lap-downloadrc">
                    <i class="fa fa-download"></i>
                    Download
                </a>
                Download <code class="inline">user.laprc</code> and move to <code class="inline">$HOME/.laprc</code>
            </section>
            <div class="lap-account pure-g">
                <div class="pure-u-2-3">
                    <a href="<?php echo ( ! $user->twitter_id ) ? page_link("signin/twitter?c=1") : "#";?>" class="pure-button lap-account-button lap-account-twitter<?php echo ( $user->twitter_id ) ? " disabled" : "";?>">
                        <i class="fa fa-twitter"></i>
                        Connect with Twitter
                    </a>
                </div>
                <div class="pure-u-1-3 lap-account-authorize">
                    <?php if ( ! $user->twitter_id ):?>
                    <span>Not connected</span>
                    <?php else:?>
                    <span class="connected">
                        <i class="fa fa-check"></i>Connected
                    </span>
                    <?php endif;?>
                </div>
            </div>
            <div class="lap-account pure-g">
                <div class="pure-u-2-3">
                    <a href="<?php echo ( ! $user->github_id ) ? page_link("signin/github?c=1") : "#";?>" class="pure-button lap-account-button lap-account-github<?php echo ( $user->github_id ) ? " disabled" : "";?>">
                        <i class="fa fa-github-alt"></i>
                        Connect with Github
                    </a>
                </div>
                <div class="pure-u-1-3 lap-account-authorize">
                    <?php if ( ! $user->github_id ):?>
                    <span>Not connected</span>
                    <?php else:?>
                    <span class="connected">
                        <i class="fa fa-check"></i>Connected
                    </span>
                    <?php endif;?>
                </div>
            </div>
        </section>
<?php echo $this->partial("partial/footer");?>
