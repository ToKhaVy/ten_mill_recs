<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CSV Upload/Download</title>
</head>

<body>
    <form action="upload_file.php" method="post" enctype="multipart/form-data">
        <label for="csv-file">Choose File:</label>
        <input type="file" name="csv-file" id="csv-file" accept=".csv" required>
        <input type="submit" value="Upload" name="submit"></input>
    </form>

    <form action="conditional_export.php" method="post">
        <label for="sort_field">Sort by Field:</label>
        <select name="sort_field" id="sort_field">
            <option value="Address">Address</option>
            <option value="Birthday">Birthday</option>
            <!-- Add more options based on your table columns -->
        </select>

        <label for="sort-order">Sort Order:</label>
        <select name="sort-order" id="sort-order">
            <option value="ASC">Ascending</option>
            <option value="DESC">Descending</option>
        </select>

        <button type="submit">Download</button>
    </form>
</body>

</html>