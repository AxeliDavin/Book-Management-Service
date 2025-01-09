<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
</head>
<body>

<h1>Books List</h1>

<!-- Displaying any messages like errors or success -->
<?php if (session()->getFlashdata('error')): ?>
    <p style="color: red;"><?php echo session()->getFlashdata('error'); ?></p>
<?php endif; ?>
<?php if (session()->getFlashdata('success')): ?>
    <p style="color: green;"><?php echo session()->getFlashdata('success'); ?></p>
<?php endif; ?>

<?php if (!session()->get('auth_token')): ?>
    <p>You need to log in to access this page.</p>
    <a href="/login">Go to Login</a>
<?php else: ?>
    <!-- Logout Button -->
    <form action="/logout" method="post" style="display:inline;">
        <?= csrf_field() ?>
        <button type="submit">Logout</button>
    </form>

    <!-- Display the books list -->
    <table border="1">
        <!-- your book listing code here -->
    </table>
<?php endif; ?>

<!-- Table to display books -->
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>ISBN</th>
            <th>Published Date</th>
            <th>Availability Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?= esc($book['id']) ?></td>
                <td><?= esc($book['title']) ?></td>
                <td><?= esc($book['author']) ?></td>
                <td><?= esc($book['genre']) ?></td>
                <td><?= esc($book['isbn']) ?></td>
                <td><?= esc($book['published_date']) ?></td>
                <td><?= esc($book['availability_status']) ?></td>
                <td>
                    <a href="<?= site_url('books/update/' . $book['id']) ?>">Edit</a> |
                    <form action="<?= site_url('books/delete/' . $book['id']) ?>" method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?');">Delete</button> |
                    </form>
                    <a href="<?= site_url('books/toggleAvailability/' . $book['id']) ?>" class="btn btn-warning">
                        <?= $book['availability_status'] == 'Available' ? 'Mark as Borrowed' : 'Mark as Available' ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<hr>

<h2>Add New Book</h2>
<form action="<?= site_url('books/create') ?>" method="post">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required><br><br>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" required><br><br>

    <label for="genre">Genre:</label>
    <input type="text" id="genre" name="genre" required><br><br>

    <label for="isbn">ISBN:</label>
    <input type="text" id="isbn" name="isbn" required><br><br>

    <label for="published_date">Published Date:</label>
    <input type="date" id="published_date" name="published_date" required><br><br>

    <label for="availability_status">Availability Status:</label>
    <select id="availability_status" name="availability_status">
        <option value="Available">Available</option>
        <option value="Borrowed">Borrowed</option>
    </select><br><br>

    <button type="submit">Add Book</button>
</form>

</body>
</html>
