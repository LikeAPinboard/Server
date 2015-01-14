<?php echo $this->partial("partial/header");?>

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
            </div>
            <div class="pure-u-2-5">
                <h3 class="lap-caption">Recent tags</h3>
                <div class="lap-tag-list">
                <?php foreach ( $tags as $tag ):?>
                <a class="lap-tag" href="<?php echo page_link("u:$targetUser->name}?t={$tag->name}");?>"><?php echo prep_str($tag->name);?>[<?php echo prep_str($tag->cnt);?>]</span>
                <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>

<?php echo $this->partial("partial/footer");?>
