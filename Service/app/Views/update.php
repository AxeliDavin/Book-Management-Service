<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
</head>
<body>

<h1>Edit Book</h1>

<form action="<?= site_url('books/update/' . $book['id']) ?>" method="post">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?= esc($book['title']) ?>" required><br><br>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" value="<?= esc($book['author']) ?>" required><br><br>

    <label for="available">Available:</label>
    <select id="available" name="available">
        <option value="1" <?= $book['available'] == 1 ? 'selected' : '' ?>>Available</option>
        <option value="0" <?= $book['available'] == 0 ? 'selected' : '' ?>>Not Available</option>
    </select><br><br>

    <button type="submit">Update Book</button>
</form>


<a href="<?= site_url('books') ?>">Back to List</a>

</body>
</html>
