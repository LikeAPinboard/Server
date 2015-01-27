<script type="text/x-retriever-template" id="subscribe-modal">
<div class="lap-section lap-modal-frame lap-confirm-subscribe">
    <h4 class="lap-section-caption">Select subscribe email</h4>
    <div class="lap-modal-content">
        <?php if ( count($emails) ):?>
        <p class="notification">Select receive email address and times</p>
        <form action="<?php echo page_link("subscribe");?>" method="post">
            <ul class="lap-emails">
                <?php foreach ( $emails as $email ):?>
                <li>
                    <label>
                    <input type="radio" name="emailId" value="<?php echo prep_str($email->id);?>"<?php echo ( $email->primary_use > 0 ) ? " checked" : "";?>>
                        <div>
                            <i class="fa fa-envelope-o"></i>
                            <?php echo prep_str($email->email);?>
                        </div>
                    </label>
                </li>
                <?php endforeach;?>
            </ul>
            <?php if ( isset($cronList) ):?>
            <p class="notification">Choose receive mail times you want:</p>
            <ul class="lap-emails">
                <?php foreach ( $cronList as $cron ):?>
                <li>
                    <label>
                    <input type="radio" name="cronId" value="<?php echo prep_str($cron->id);?>"<?php echo ( $cron->id == 1 ) ? " checked" : "";?>>
                    <div><i class="fa fa-clock-o"></i><?php echo prep_str($cron->time);?></div>
                    </label>
                </li>
                <?php endforeach;?>
            </ul>
            <?php endif;?>
                        
            <?php if ( $tag ):?>
            <input type="hidden" name="tag" value="<?php echo prep_str($tag);?>">
            <?php endif;?>
            <input type="hidden" name="userId" value="<?php echo prep_str($targetUser->id);?>">
            <input type="hidden" name="token" value="<?php echo $token;?>">
            <button type="submit" class="pure-button pure-button-primary" data-process="username">Subscribe</button>
            <p>Do you want to receive other address?<br>Add new email at <a href="<?php echo page_link("my/account");?>">Account page</a></p>
        </form>
        
        <?php else:?>
        <p class="notification">
            Email has not registered yet.<br>
            Regiter email at <a href="<?php echo page_link("my/account");?>">Account page</a>
        </p>
        <?php endif;?>
    </div>
    <a href="#" class="lap-modal-close" data-close="1">
        <i class="fa fa-close"></i>
    </a>
</div>
</script>
