<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
</head>
<body>

<h1>Edit Book</h1>

<!-- Form to edit the book details -->
<form action="<?= site_url('books/update/' . $book['id']) ?>" method="post">
    <?= csrf_field() ?>

    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?= esc($book['title']) ?>" required><br><br>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" value="<?= esc($book['author']) ?>" required><br><br>

    <label for="genre">Genre:</label>
    <input type="text" id="genre" name="genre" value="<?= esc($book['genre']) ?>" required><br><br>

    <label for="isbn">ISBN:</label>
    <input type="text" id="isbn" name="isbn" value="<?= esc($book['isbn']) ?>" required><br><br>

    <label for="published_date">Published Date:</label>
    <input type="date" id="published_date" name="published_date" value="<?= esc($book['published_date']) ?>" required><br><br>

    <label for="availability_status">Availability Status:</label>
    <select id="availability_status" name="availability_status">
        <option value="Available" <?= $book['availability_status'] == 'Available' ? 'selected' : '' ?>>Available</option>
        <option value="Borrowed" <?= $book['availability_status'] == 'Borrowed' ? 'selected' : '' ?>>Borrowed</option>
    </select><br><br>

    <button type="submit">Update Book</button>
</form>

<hr>

<a href="<?= site_url('books') ?>">Back to List</a>

</body>
</html>