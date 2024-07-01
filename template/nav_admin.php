<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">FODIS - Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index_admin.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="../admin/tambah_post.php">Posting</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/profil.php"> Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/data_user.php"> Banned
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../view/logout.php">Logout</a>
                </li>
            </ul>
            <form class="d-flex mx-auto" role="search" method="get" action="index.php">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>