<div class="row">
    <div class="col-md-8">
        <h2>My Subscribed Feeds</h2>
        <?php if (isset($this->_data['success'])) : ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">&times;</button>
                <?php echo html($this->_data['success']); ?>
            </div>
        <?php elseif (isset($this->_data['error'])) : ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">&times;</button>
                <?php echo html($this->_data['error']); ?>
            </div>
        <?php endif; ?>

    <?php if (count($this->_data['feeds']) > 0) : ?>
        <dl>
        <?php foreach ($this->_data['feeds'] as $feed) : ?>
            <dt>
               <a href="/feeds/<?php echo html(urlencode($feed->getId())); ?>"
                    title="<?php echo html($feed->title); ?>">
                    <?php echo $feed->title; ?>
                </a>
            </dt>
            <dd>
                <?php echo $feed->description; ?>
                <br>
                <form action="/unsubscribe" method="POST">
                    <input type="hidden" name="feed_id"
                        value="<?php echo html($feed->getId()); ?>">
                    <button type="submit" class="btn btn-info btn-sm">Unsubscribe</button>
                </form>
            </dd>
            <hr>
        <?php endforeach; ?>
        </dl>
    <?php else : ?>
        <p>Nothing yet!</p>
    <?php endif; ?>
    </div>
    <?php require 'views/partials/sidebar.html.php'; ?>
</div>

