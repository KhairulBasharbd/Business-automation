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
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Product Management</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">Add New Item</button>
        </div>

        <!-- Cart Section -->
        <div class="card shadow p-3">
            <h4 class="text-center text-success">Shopping Cart</h4>
            <table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        @if(session('cart'))
            @foreach(session('cart') as $id => $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>${{ number_format($product['price'], 2) }}</td>
                    <td>{{ $product['quantity'] }}</td>
                </tr>
            @endforeach
        @else
            <tr><td colspan="3" class="text-center">No items in cart</td></tr>
        @endif
    </tbody>
</table>

            <div class="d-flex justify-content-end">
                <button class="btn btn-danger" id="clearCart">Clear Cart</button>
            </div>
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

    <!-- jQuery Script -->
    <script>
        $(document).ready(function() {
            // Handle product addition
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
                        console.log(xhr); // Debugging
                        let errorMessage = xhr.responseJSON?.error || "Something went wrong!";
                        alert("Error: " + errorMessage);
                    }
                });
            });

            // Handle cart operations
            let cart = [];

            function updateCart() {
                let cartHtml = "";
                cart.forEach((item, index) => {
                    cartHtml += `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.type}</td>
                            <td>$${item.price}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="decreaseQuantity(${index})">-</button>
                                ${item.quantity}
                                <button class="btn btn-sm btn-success" onclick="increaseQuantity(${index})">+</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="removeItem(${index})">Delete</button>
                            </td>
                        </tr>
                    `;
                });

                $("#cartBody").html(cartHtml);
            }

            function increaseQuantity(index) {
                cart[index].quantity++;
                updateCart();
            }

            function decreaseQuantity(index) {
                if (cart[index].quantity > 1) {
                    cart[index].quantity--;
                } else {
                    cart.splice(index, 1);
                }
                updateCart();
            }

            function removeItem(index) {
                cart.splice(index, 1);
                updateCart();
            }

            $("#clearCart").click(function() {
                cart = [];
                updateCart();
            });
        });
    </script>

</body>
</html>
