<div class="row">
    <div class="col-md-8">
        <h2>Recently Subscribed</h2>

        <?php if (count($this->_data) > 0) : ?>
        <dl>
            <?php foreach ($this->_data as $feed) : ?>
                <dt>
                    <a href="/feeds/<?php echo html(urlencode($feed->getId())); ?>"
                        title="<?php echo html($feed->title); ?>">
                        <?php echo $feed->title; ?>
                    </a>
                </dt>
                <dd><?php echo $feed->description; ?></dd>
                <hr>
            <?php endforeach; ?>
        </dl>
        <?php else : ?>
            <p>Nothing yet!</p>
        <?php endif; ?>
    </div>

    <?php require 'views/partials/sidebar.html.php'; ?>
</div>
