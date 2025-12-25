<!-- Foodpanda-style Item Detail Modal -->
<div class="modal fade" id="itemDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 600px;">
        <div class="modal-content" style="border-radius: 15px; border: none; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            
            <!-- Close Button (Absolute) -->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" 
                style="position: absolute; top: 15px; right: 15px; z-index: 10; background: white; width: 35px; height: 35px; border-radius: 50%; opacity: 1; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <span aria-hidden="true" style="color: #333; font-size: 24px; line-height: 1;">&times;</span>
            </button>

            <!-- Image Header -->
            <div class="modal-header-img" style="height: 300px; width: 100%; position: relative;">
                <img id="modalItemImage" src="" alt="Item Image" style="width: 100%; height: 100%; object-fit: cover;">
                <div id="modalItemDiscountBadge" style="position: absolute; top: 15px; left: 15px; background: #ea005e; color: white; padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 700; display: none; align-items: center; box-shadow: 0 4px 10px rgba(234, 0, 94, 0.3);">
                    <span class="icon ion-pricetag" style="margin-right: 5px; font-size: 15px;"></span> 
                    <span id="modalItemDiscountPercent"></span>% off
                </div>
            </div>

            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 id="modalItemName" style="font-weight: 700; color: #333; margin: 0;"></h3>
                </div>
                
                <div class="mb-4">
                    <span id="modalItemPriceOriginal" style="color: #999; text-decoration: line-through; font-size: 1.1rem; margin-right: 10px; display: none;"></span>
                    <span id="modalItemPriceDiscount" style="color: #ff2b85; font-size: 1.5rem; font-weight: 700;"></span> <!-- Foodpanda Pink: #ff2b85 -->
                </div>

                <p id="modalItemDescription" style="color: #666; font-size: 1rem; line-height: 1.6; margin-bottom: 30px;"></p>

                <!-- Quantity & Add Button Row -->
                <form id="modalAddToCartForm" action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center justify-content-between">
                    @csrf
                    <input type="hidden" name="menu_item_id" id="modalItemId">
                    <input type="hidden" name="quantity" value="1"> 
                    
                    <!-- Simple Quantity (Optional: Can expand later) -->
                    <!-- For now, simplifying to just "Add to Cart" as typically that's the primary action, quantity can be managed in cart or added here if needed. 
                         Foodpanda usually has a big pink bar. -->
                    
                    <button type="submit" class="btn btn-primary btn-block py-3" style="background-color: #ff2b85; border-color: #ff2b85; font-weight: 700; border-radius: 8px; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(255, 43, 133, 0.3);">
                        Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openItemModal(item) {
        // Populate Data
        $('#modalItemId').val(item.id);
        $('#modalItemName').text(item.name);
        $('#modalItemDescription').text(item.description);
        
        // Image
        var imgSrc = item.photo_path ? '{{ asset("storage") }}/' + item.photo_path : '{{ asset("images/img_1.jpg") }}';
        $('#modalItemImage').attr('src', imgSrc);
        
        // Price Formatting
        var price = parseFloat(item.price);
        var discountPrice = item.discount_price ? parseFloat(item.discount_price) : null;
        
        if (discountPrice && discountPrice < price) {
            $('#modalItemPriceOriginal').text('$' + price.toFixed(2)).show();
            $('#modalItemPriceDiscount').text('$' + discountPrice.toFixed(2));
            
            if (item.discount_percentage > 0) {
                $('#modalItemDiscountPercent').text(item.discount_percentage);
                $('#modalItemDiscountBadge').css('display', 'flex');
            } else {
                $('#modalItemDiscountBadge').hide();
            }
        } else {
            $('#modalItemPriceOriginal').hide();
            $('#modalItemPriceDiscount').text('$' + price.toFixed(2));
            $('#modalItemDiscountBadge').hide();
        }
        
        // Show Modal
        $('#itemDetailModal').modal('show');
    }

    // AJAX Handling for the Modal Form
    $('#modalAddToCartForm').on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Stop global handler from firing
        var form = $(this);
        var btn = form.find('button[type="submit"]');
        var originalText = btn.html();
        
        btn.html('Adding...').prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Close modal
                $('#itemDetailModal').modal('hide');
                
                // Update badge
                $('#cartBadgeCount').text(response.cart.count);
                
                // Reset button
                btn.html(originalText).prop('disabled', false);
            },
            error: function() {
                alert('Error adding to cart');
                btn.html(originalText).prop('disabled', false);
            }
        });
    });
</script>
