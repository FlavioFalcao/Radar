<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2>Sign up</h2>
        <?php if (count($this->_data['errors']) > 0) : ?>
            <?php foreach ($this->_data['errors'] as $error) : ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">&times;</button>
                    <?php echo html($error); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <form role="form" action="/signup" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" name="email" id="email"
                    value="<?php echo html($this->_data['email']); ?>">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username"
                    id="username" value="<?php echo html($this->_data['username']); ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password"
                    id="password">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password"
                    id="confirm_password">
            </div>

            <button type="submit" class="btn btn-default">Sign in</button>
        </form>
    </div>
</div>

