<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Product Management</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">Add New Item</button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addProductForm">
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter product name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Type</label>
                                <select class="form-select" name="type" required>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Clothing">Clothing</option>
                                    <option value="Grocery">Grocery</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Purchase Price</label>
                                <input type="number" class="form-control" name="purchase_price" placeholder="Enter purchase price" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Selling Price</label>
                                <input type="number" class="form-control" name="selling_price" placeholder="Enter selling price" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Save Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#addProductForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('products.store') }}",
                type: "POST",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.success);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.error);
                }
            });
        });
    });
</script>

</body>
</html>
