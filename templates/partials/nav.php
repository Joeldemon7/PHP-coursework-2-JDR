<!-- Inside templates/partials/nav.php -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Existing navigation links -->
        <li class="nav-item">
          <a class="nav-link" href="modules.php">My Modules</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="students.php">Students</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="addstudent.php">Add student</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="assignmodule.php">Assign Module</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="details.php">My Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <!-- Search button -->
        <li class="nav-item">
          <form class="d-flex" action="search.php" method="GET"> <!-- Search functionality is handled by search.php -->
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="q">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>

