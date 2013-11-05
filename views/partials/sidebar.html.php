<div class="col-md-4">
    <div class="panel panel-default">
        <?php if (User::current()) : ?>
        <div class="panel-heading">
            <h4>Control Center</h4>
        </div>
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="#" data-toggle="modal" data-target="#subscribeModal" title="Add feed">
                        Add a feed
                    </a>
                </li>
                <li><a href="/signout" title="Sign out">Sign out</a></li>
            </ul>
        </div>
        <?php else : ?>
        <div class="panel-heading">
            <h4>Not a member yet?</h4>
        </div>
        <div class="panel-body">
            <p>
                <strong>
                    <a href="/signup" title="Sign up">Sign up now!</a>
                </strong>
            </p>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="subscribeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true">&times;</button>
                <h4>Subscribe to a feed</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" action="/subscribe" id="subscribeForm"
                    method = "POST" role="form">
                    <div class="form-group">
                        <label for="url">Address</label>
                        <input type="text" class="form-control" id="url"
                            name="url">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="subscribeButton">
                    Subscribe
                </button>
            </div>
        </div>
    </div>
</div>
