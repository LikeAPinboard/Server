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
   <?php if ( $subscribed === 0 ):?>
       <div class="lap-auth-result lap-notification auth-success">
           <p>Subscribed.</p>
       </div>
   <?php elseif ( $subscribed === 1 ):?>
       <div class="lap-auth-result lap-notification auth-error">
           <p>Subscribe failed.</p>
       </div>
    <?php endif;?>
    <h2 class="lap-title"><?php echo prep_str($targetUser->name);?> pins</h2>
    <div class="lap-content">
        <div class="pure-g">
            <div class="pure-u-3-5">
                <ul class="lap-pin-list">
                    <?php foreach ( $pins as $pin ):?>
                    <li class="lap-pin">
                        <a href="<?php echo prep_str($pin->url);?>" title="<?php echo prep_str($pin->title);?>">
                            <?php echo prep_str($pin->title);?>
                        </a>
                        <p class="lap-tags">
                            <?php foreach ( $pin->tags as $tag ):?>
                            <a class="lap-tag" href="<?php echo page_link("u:{$targetUser->name}?t={$tag->name}");?>"><?php echo prep_str($tag->name);?></a>
                            <?php endforeach;?>
                        </p>
                        <p class="lap-etc">pined at <?php echo prep_str($pin->created_at);?></p>
                    </li>
                    <?php endforeach;?>
                </ul>
                <?php echo $Paginate->generate();?>
            </div>
            <div class="pure-u-2-5">
                <h3 class="lap-caption">Recent tags</h3>
                <div class="lap-tag-list">
                <?php if ( count($tags) > 0 ):?>
                    <?php foreach ( $tags as $tag ):?>
                        <a class="lap-tag" href="<?php echo page_link("u:{$targetUser->name}?t={$tag->name}");?>"><?php echo prep_str($tag->name);?></span></a>
                    <?php endforeach;?>
                <?php else:?>
                    <p>No tags</p>
                <?php endif;?>
                </div>

                <?php if ( isset($followed) ):?>
                    <h3 class="lap-caption">Follow</h3>
                    <div class="lap-action-list">
                        <?php if ( ! $followed ):?>
                        <a class="pure-button pure-button-primary" href="<?php echo page_link("user/follow/{$targetUser->name}?token={$token}");?>">
                            <i class="fa fa-plus-circle"></i>Follow
                        </a>
                        <?php else:?>
                        <a class="pure-button" href="<?php echo page_link("user/unfollow/{$targetUser->name}?token={$token}");?>">
                            <i class="fa fa-minus-circle"></i>Remove
                        </a>
                        <?php endif;?>
                    <?php if ( isset($subscribed) ):?>
                        <?php if ( $subscribed ):?>
                        <button class="pure-button pure-button-disabled" disabled>
                            <i class="fa fa-check"></i>Subscribed
                        </button>
                        <?php else:?>
                        <button class="pure-button pure-button-primary" id="lap-subscribe-user">
                            <i class="fa fa-plus-circle"></i>Subscribe
                        </button>
                        <?php endif;?>

                    <?php endif;?>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>

<?php echo $this->partial("partial/footer");?>
