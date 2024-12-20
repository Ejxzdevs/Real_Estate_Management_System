<?php
require_once 'app/http/helper/csrfHelper.php';
require_once 'app/http/helper/displayProduct.php';
$products = new DisplayProduct();
$data = $products->getAllProducts();
$csrf_token = CsrfHelper::generateToken();
?>
<div class="d-flex flex-column p-4">
    <div class="d-flex flex-row justify-content-between w-100 h-100 mb-2">
        <h5 class="mt-3">Products</h5>
        <button class="btn btn-primary me-3" style="width: 120px; height: 2.5rem;" data-bs-toggle="modal" data-bs-target="#addProperty">ADD</button>
    </div>
    <div class="table-container">
        <table class="table align-middle mb-0 bg-white p-3 ">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $product): ?>
                    <tr>
                        <td><img src="public/images/products/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image"></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['address']); ?></td>
                        <td><?php echo htmlspecialchars($product['price']); ?></td>
                        <td><?php echo htmlspecialchars($product['status']); ?></td>
                        <td><div class="table-actions">
                        <a href="#" 
                               onclick="
                                document.getElementById('updatePropertyID').value = '<?php echo htmlspecialchars($product['id']); ?>';
                                document.getElementById('updatePropertyName').value = '<?php echo htmlspecialchars($product['name']); ?>';
                                document.getElementById('updatePropertyDescription').value = '<?php echo htmlspecialchars($product['description']); ?>';
                                document.getElementById('updatePropertyAddress').value = '<?php echo htmlspecialchars($product['address']); ?>';
                                document.getElementById('updatePropertyPrice').value = '<?php echo htmlspecialchars($product['price']); ?>';
                                document.getElementById('updatePropertyStatus').value = '<?php echo htmlspecialchars($product['status']); ?>';
                                document.getElementById('updateTransactionType').value = '<?php echo htmlspecialchars($product['transaction_type']); ?>';
                                document.getElementById('updatePropertyImage').value = '<?php echo htmlspecialchars($product['image']); ?>';
                                document.getElementById('imageUpdatePreview').src = 'public/images/products/<?php echo htmlspecialchars($product['image']); ?>';
                                document.getElementById('imageUpdatePreview').style.display = 'block';
                               "
                               data-bs-toggle="modal" data-bs-target="#updateProperty" class="edit" ><i class="bi bi-pencil-square"></i></a>
                               <form action="app/http/controller/productController.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                                    <input type="hidden" name="delete">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                    <button type="submit" class="delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                                </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Property Modal -->
<div class="modal fade" id="addProperty" tabindex="-1" aria-labelledby="addProperty" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="app/http/controller/productController.php" method="POST" id="addPropertyForm" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                    <input type="hidden" name="insert">
                    <div class="mb-3">
                        <label for="propertyName" class="form-label">Property Name</label>
                        <input type="text" name="propertyName" class="form-control" id="propertyName" required>
                    </div>
                    <div class="mb-3">
                        <label for="propertyDescription" class="form-label">Description</label>
                        <textarea name="propertyDescription" class="form-control" id="propertyDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="propertyAddress" class="form-label">Address</label>
                        <input type="text" name="propertyAddress" class="form-control" id="propertyAddress" required>
                    </div>
                    <div class="mb-3">
                        <label for="propertyPrice" class="form-label">Price</label>
                        <input type="text" name="propertyPrice" class="form-control" id="propertyPrice" required>
                    </div>
                    <div class="mb-3">
                        <label for="propertyStatus" class="form-label">Status</label>
                        <select class="form-select" name="propertyStatus" id="propertyStatus" required>
                            <option value="" disabled selected>Select status</option>
                            <option value="available">Available</option>
                            <option value="sold">Sold</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="propertyImage" class="form-label">Upload Image</label>
                        <input type="file" name="propertyImage" class="form-control" id="propertyImage" accept="image/*" onchange="previewImage(event)" required>
                    </div>
                    <div class="mb-3">
                        <img id="imagePreview" src="" alt="Image Preview" style="display: none; max-width: 100%; height: auto;">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="addPropertyForm">Add Property</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateProperty" tabindex="-1" aria-labelledby="updateProperty" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="app/http/controller/productController.php" method="POST" id="updatePropertyForm" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                    <input type="hidden" name="update">
                    <input type="hidden" name="id" class="form-control" id="updatePropertyID" required>
                    <div class="mb-3">
                        <label for="updatePropertyName" class="form-label">Property Name</label>
                        <input type="text" name="propertyName" class="form-control" id="updatePropertyName" required>
                    </div>
                    <div class="mb-3">
                        <label for="updatePropertyDescription" class="form-label">Description</label>
                        <textarea name="propertyDescription" class="form-control" id="updatePropertyDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="updatePropertyAddress" class="form-label">Address</label>
                        <input type="text" name="propertyAddress" class="form-control" id="updatePropertyAddress" required>
                    </div>
                    <div class="mb-3">
                        <label for="updatePropertyPrice" class="form-label">Price</label>
                        <input type="text" name="propertyPrice" class="form-control" id="updatePropertyPrice" required>
                    </div>
                    <div class="mb-3">
                        <label for="updatePropertyStatus" class="form-label">Status</label>
                        <select class="form-select" name="propertyStatus" id="updatePropertyStatus" required>
                            <option value="" disabled selected>Select status</option>
                            <option value="available">Available</option>
                            <option value="sold">Sold</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="updateTransactionType" class="form-label">Transaction Type</label>
                        <select class="form-select" name="transactionType" id="updateTransactionType" required>
                            <option value="" disabled selected>Select status</option>
                            <option value="sell">Sell</option>
                            <option value="rent">Rent</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Update Image</label>
                        <input type="file" name="propertyImage" class="form-control" accept="image/*" onchange="previewUpdateImage(event)">
                    </div>
                    <div class="mb-3">
                        <img id="imageUpdatePreview" src="" alt="Image Preview" style="display: none; max-width: 100%; height: auto;">
                        <input type="hidden" name="prePropertyImage" class="form-control" id="updatePropertyImage" accept="image/*" >
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="updatePropertyForm">Update Property</button>
            </div>
        </div>
    </div>
</div>
