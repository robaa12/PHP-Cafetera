<!-- add_product.php -->
<link rel="stylesheet" href="/PHP-Cafetera/public/assets/css/bootstrap.css">
<link rel="stylesheet" href="/PHP-Cafetera/public/assets/css/navbar.css">





















<style>
  .panel{
    background: #f7f1ea;
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,.08);
    padding: 22px;
  }
  .req{ color:#b42318; font-weight:600; }

  .upload-box{
    border: 2px dashed rgba(0,0,0,.25);
    border-radius: 14px;
    background: rgba(255,255,255,.35);
    min-height: 240px;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    padding: 18px;
  }
  .upload-box input[type="file"]{ display:none; }
  .upload-label{ cursor:pointer; width:100%; }
  .upload-hint{ color: rgba(0,0,0,.65); font-size:.95rem; }

 
.modal {
  display: none; /* Hidden by default */
  position: fixed; 
  z-index: 1000; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%;          
  overflow: auto; 
  background-color: rgba(0,0,0,0.5); /* Semi-transparent black */
}

/* Modal Box */
.modal-content {
  background-color: #fff;
  margin: 10% auto; /* 10% from top, centered */
  padding: 20px;
  border-radius: 10px;
  width: 50%; /* adjust as needed */
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  position: relative;
}

.close {
  color: #aaa;
  position: absolute;
  top: 10px;
  right: 20px;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover {
  color: #000;
}




</style>

<div class="app">
  <?php
    $active = 'products';
    require_once __DIR__ . '/../layouts/navbar.php';
    require_once __DIR__ . '/../../controllers/categoryController.php'
  ?>


  <main class="content">
    <div class="panel">
      <h2 class="mb-1">Add New Product</h2>
      <div class="text-muted small mb-4">Dashboard &gt; Products &gt; Add New Product</div>

      <form method="post" enctype="multipart/form-data">
        <div class="row g-4">
          <div class="col-12 col-lg-6">
            <h5 class="mb-3">Product Information</h5>

            <div class="mb-3">
              <label for="name" class="form-label">
                Product Name <span class="req">(Required)</span>
              </label>
              <input
                id="name"
                name="name"
                type="text"
                class="form-control"
                placeholder="e.g., Tea"
                required
              >
            </div>

            <div class="mb-3">
              <label for="category" class="form-label">
                Category <span class="req">(Required)</span>
              </label>
              <select id="category" name="category_id" class="form-select" required>
                <option value="" selected disabled>Choose...</option>
                <?php
                $categoryModel = new CategoryController;
                $cat_list = $categoryModel->showAllCategories();
                foreach($cat_list as $cat){
                echo '<option value="' . $cat["name"] . '">' . $cat["name"] . '</option>';

                }

                
                ?>
              </select>

              <div class="mt-2">
                <a href="#" id="openModalLink" class="link-success text-decoration-underline">
                  Add New Category
                </a>
              </div>
            </div>

            <div class="mb-3">
              <label for="price" class="form-label">
                Selling Price <span class="req">(Required)</span>
              </label>
              <div class="input-group" style="max-width: 320px;">
                <span class="input-group-text">EGP</span>
                <input
                  id="price"
                  name="price"
                  type="number"
                  step="0.01"
                  min="0"
                  class="form-control"
                  placeholder="0.00"
                  required
                >
              </div>
            </div>

            <div class="d-flex gap-2 mt-4">
              <button type="submit" class="btn btn-success px-4">Save Product</button>
              <button type="reset" class="btn btn-outline-secondary px-4">Reset</button>
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <h5 class="mb-3">Media</h5>

            <div class="upload-box">
              <label class="upload-label" for="image">
                <div class="fw-semibold mb-2">
                  Product Image <span class="req">(Required)</span>
                </div>
                <div class="upload-hint">Click to upload</div>
                <div class="upload-hint small">PNG / JPG</div>
              </label>
              <input id="image" name="image" type="file" accept="image/*" required>
            </div>
          </div>
        </div>
      </form>
    </div>

      <?php if(isset($_GET['msg']) ):
        switch($_GET['msg']){
            case "category_Added":
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Category Added Successfully!
    </div>';
    break;
    case "category_exists":
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Category Already Exists!
    </div>';
    break;
        }
        ?>
        
    
<?php endif; ?>

    
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Add New Category
    </h2>
    <form action="/PHP-CAFETERA/app/controllers/categoryController.php" method="post">
      <label for="name">Name:</label>
      <input type="text" name="name" id="name" required>
      <br><br>
 
      <button class="btn btn-success" type="submit">ADD</button>
    </form>
  </div>
</div>
  </main>
</div>
<script>
// Get modal and link
const modal = document.getElementById("myModal");
const link = document.getElementById("openModalLink");
const span = document.getElementsByClassName("close")[0];
   
// Open modal on link click
link.onclick = function(event) {
  event.preventDefault(); // prevent anchor from navigating
  modal.style.display = "block";
}

// Close modal when clicking the X
span.onclick = function() {
  modal.style.display = "none";
}

// Close modal when clicking outside the modal box
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>