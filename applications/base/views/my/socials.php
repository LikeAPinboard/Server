<?php echo $this->partial("partial/header");?>
        <section class="lap-content">
            <h2 class="lap-title">Social account connections</h2>
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
            <div class="lap-account pure-g">
                <div class="pure-u-2-3">
                    <a href="<?php echo ( ! $user->facebook_id ) ? page_link("signin/facebook?c=1") : "#";?>" class="pure-button lap-account-button lap-account-github<?php echo ( $user->facebook_id ) ? " disabled" : "";?>">
                        <i class="fa fa-facebook-square"></i>
                        Connect with Facebook
                    </a>
                </div>
                <div class="pure-u-1-3 lap-account-authorize">
                    <?php if ( ! $user->facebook_id ):?>
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
