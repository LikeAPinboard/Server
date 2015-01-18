        <footer class="lap-footer">
            <p>Like A Pinboard, manage your bookmarks.</p>
        </footer>
        <?php if ( isset($overlay) ):?>
        <div class="lap-overlay"></div>
        <?php endif;?>
        <?php if ( isset($modals) ):?>
            <?php foreach( (array)$modals as $modal ):?>
            <?php echo $this->partial($modal);?>
            <?php endforeach;?>
        <?php endif;?>
        <script src="<?php echo base_link("js/index.js");?>"></script>
    </body>
</html>
