<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Email</th>
            <th>Content</th>
            <th>Status</th>
            <th>Date</th>
            <th>In Response To</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
        <?php displayCommentsTable(); ?>
        <?php approveComment(); ?>
    </tbody>
</table>