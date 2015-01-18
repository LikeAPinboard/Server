<?php echo $this->partial("partial/header");?>
        <section class="lap-content">
            <h2 class="lap-title">API tools</h2>
            <div class="lap-tabs">
                <div class="pure-menu pure-menu-open pure-menu-horizontal">
                   <ul>
                        <li class="pure-menu-selected"><a href="#" class="lap-extension">Chrome Extension</a></li>
                        <li><a href="#" class="lap-alfred">Alfred Workflow</a></li>
                    </ul>
                </div>
            </div>
            <section class="lap-token lap-tab-content" id="lap-extension-content">
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
            </section>
            <section class="lap-token lap-hidden lap-tab-content" id="lap-alfred-content">
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
        </section>
<?php echo $this->partial("partial/footer");?>
