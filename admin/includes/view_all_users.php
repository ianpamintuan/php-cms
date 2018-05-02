<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Role</th>
            <th colspan=4 style="text-align: center;">Options</th>
        </tr>
    </thead>
    <tbody>
        <?php displayUsers("table"); ?>
        <?php deleteUser(); ?>
        <?php changeRole(); ?>
    </tbody>
</table>