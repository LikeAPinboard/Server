<?php echo $this->partial("partial/header");?>
        <?php if ( $auth_result === 0 ):?>
            <div class="lap-auth-result lap-notification auth-success">
                <p>Authenticate success.</p>
            </div>
        <?php elseif ( $auth_result === 1 ):?>
            <div class="lap-auth-result lap-notification auth-error">
                <p>Authenticate error.</p>
            </div>
        <?php elseif ( $auth_result === 2 ):?>
            <div class="lap-auth-result lap-notification auth-success">
                <p>User registered.</p>
            </div>
        <?php endif;?>
        <section class="lap-content">
            <h2 class="lap-title">API tools</h2>
            <section class="lap-token">
                <h3>Chrome Extension</h3>
                <ol class="lap-tool-steps">
                    <li>
                        <h4>Download Extension</h4>
                        <p><a href="<?php echo page_link("download/extension");?>" class="pure-button button-primary">
                            <i class="fa fa-download"></i>
                            Download
                            </a> Extension, Drap and Drop to <code class="inline">chrome://extensions/</code>
                        </p>
                    </li>
                    <li>
                        <h4>Initial Setting</h4>
                        <p>When first opened extension, you need to input API settings below:</p>
                        <h5>API Server URL:</h5>
                        <p class="lap-info-value">
                        <input type="text" value="<?php echo prep_str(get_config("lap_api_server"));?>" readonly>
                        </p>
                        <h5>API Token:</h5>
                        <p class="lap-info-value">
                        <input type="text" value="<?php echo prep_str($user->token);?>" readonly>
                        </p>
                        <p>Or open extension on this page, automatic setting inputed.</p>
                    </li>
                </ol>
                <h3>Alfred workflow ( Mac OS Only )</h3>
                <ol class="lap-tool-steps">
                    <li>
                        <h4>Download workflow</h4>
                        <p><a href="<?php echo page_link("download/workflow");?>" class="pure-button button-primary">
                            <i class="fa fa-download"></i>
                            Download
                            </a> workflow, and double click to install ( need Alfred2 + powerpack )
                        </p>
                    </li>
                    <li>
                        <h4>Download .rc file</h4>
                        <p><a href="<?php echo page_link("download/rc");?>" class="pure-button button-primary">
                            <i class="fa fa-download"></i>
                            Download
                            </a> <code class="inline">user.laprc</code>, move and rename to <code class="inline">$HOME/.laprc</code>
                        </p>
                    </li>
                    <li>
                        <h4>Use workflow</h4>
                        <p>Keyword is <code class="inline">lap</code>.</p>
                    </li>
                </ol>
            </section>
            <h2 class="lap-title">Account connections</h2>
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
