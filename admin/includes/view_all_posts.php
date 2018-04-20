<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Content</th>
            <th>Author</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Views</th>
            <th>Date</th>
            <th colspan=2>Options</th>
        </tr>
    </thead>
    <tbody>
        <?php displayPostsTable(); ?>
        <?php deletePost(); ?>
    </tbody>
</table>