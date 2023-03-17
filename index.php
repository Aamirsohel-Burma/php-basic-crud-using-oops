<?php
require "./includes/crud/index-crud.php";
?>
<!doctype html>
<html lang="en">

<head>
    <title>CRUD Demo</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .thumbnail {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="jumbotron text-center">
        <h1 class="display-3">CRUD</h1>
        <p class="lead">CRUD using OOPS</p>
        <hr class="my-2">
    </div>
    <!-- Container start -->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <!-- Name Field start -->
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" value="<?= $name ?>" class="form-control" name="name" id="name" aria-describedby="nameID" placeholder="Enter your name">
                            <small id="nameID" class="form-text text-muted">E.g.: Aamir</small>
                        </div>
                    </div>
                    <!-- Name Field end -->
                    <!-- Image upload start -->
                    <div class="col-12">
                        <div class="form-group">
                            <label for="image">Upload you image</label>
                            <input type="file" class="form-control" name="image" id="image">
                        </div>
                    </div>
                    <!-- Image upload end -->
                    <!-- Display image when edit the data start -->
                    <?php if (!empty($image)) : ?>
                        <div class="col-12 mb-4">
                            <h5>Uploaded Image :</h5>
                            <img src="./assets/images/<?= $image; ?>" class="thumbnail" alt="<?= $image; ?>">
                        </div>
                        <!-- Update form button start -->
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?= $id; ?>">
                                <input type="hidden" name="previous_image" value="<?= $image; ?>">
                                <button type="submit" name="update" id="update" class="btn btn-warning btn-block">Update</button>
                            </div>
                        </div>
                        <!-- Update form button end -->
                        <!-- Redirect to insert position start -->
                        <div class="col-12">
                            <div class="form-group">
                                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-primary btn-block">Go back to insert</a>
                            </div>
                        </div>
                        <!-- Redirect to insert position end -->
                    <?php else : ?>
                        <!-- Submit form button start -->
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                        <!-- Submit form button end -->
                    <?php endif; ?>
                    <!-- Display image when edit the data start -->
                </form>
            </div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-stripped">
                        <caption>This is user data.</caption>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($userData)) : ?>
                                <?php foreach ($userData as $index => $data) : ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $data['name']; ?></td>
                                        <td><img src="./assets/images/<?= $data['image']; ?>" class="thumbnail" alt="<?= $data['image']; ?>"></td>
                                        <td><?= $data['created_at']; ?></td>
                                        <td><?= $data['updated_at']; ?></td>
                                        <td>
                                            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
                                                <button type="submit" value="<?= $data['id']; ?>" name="edit" id="edit" class="btn btn-warning m-2"><i class="fas fa-edit "></i></button>
                                                <button type="submit" value="<?= $data['id']; ?>" name="delete" id="delete" class="btn btn-danger m-2"><i class="fas fa-trash "></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="text-center">
                                    <td colspan="6 text-capitalize ">No data found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Container end -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>