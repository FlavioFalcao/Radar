<?php $feed = $this->_data['feed']; ?>
<div class="row">
    <div class="col-md-8">
        <h2>
            <a href="<?php echo html($feed->url); ?>"
                title="<?php echo html($feed->title); ?>"
                target="_blank">
                <?php echo html($feed->title); ?>
            </a>
        </h2>
        <p><?php echo html($feed->description); ?></p>
        <dl>
        <?php foreach ($this->_data['articles'] as $article) : ?>
            <dt>
                <a href="<?php echo html($article['link']); ?>"
                    title="<?php echo html($article['title']); ?>"
                    target="_blank">
                    <?php echo $article['title']; ?>
                </a>
            </dt>
            <dd>
                <br>
                <?php echo $article['description']; ?>
            </dd>
            <hr>
        <?php endforeach; ?>
        </dl>
    </div>

    <?php require 'views/partials/sidebar.html.php'; ?>
</div>

