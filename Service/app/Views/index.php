<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
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

<!-- Table to display books -->
<table border="1">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Available</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?= esc($book['title']) ?></td>
                <td><?= esc($book['author']) ?></td>
                <td><?= $book['available'] == 1 ? 'Available' : 'Not Available' ?></td>
                <td>
                    <a href="<?= site_url('books/show/' . $book['id']) ?>">View</a> |
                    <a href="<?= site_url('books/update/' . $book['id']) ?>">Edit</a> |
                    <form action="<?= site_url('books/delete/' . $book['id']) ?>" method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?');">Delete</button>
                    </form> |
                    <a href="<?= site_url('books/toggleAvailability/' . $book['id']) ?>" class="btn btn-warning">
                        <?= $book['available'] == 1 ? 'Mark as Not Available' : 'Mark as Available' ?>
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

    <label for="available">Available:</label>
    <select id="available" name="available">
        <option value="1">Available</option>
        <option value="0">Not Available</option>
    </select><br><br>

    <button type="submit">Add Book</button>
</form>

</body>
</html>
