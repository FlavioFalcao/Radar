<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2>Sign in</h2>
        <?php if (count($this->_data['errors']) > 0) : ?>
            <?php foreach ($this->_data['errors'] as $error) : ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">&times;</button>
                    <?php echo html($error); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <form role="form" action="/signin" method="POST">
            <div class="form-group">
                <label for="username">Username or E-mail Address</label>
                <input type="text" class="form-control" name="username"
                    id="username" value="<?php echo html($this->_data['username']); ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password"
                    id="password">
            </div>

            <button type="submit" class="btn btn-default">Sign in</button>
        </form>
    </div>
</div>
