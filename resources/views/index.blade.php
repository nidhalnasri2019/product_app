<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Application Using Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
     crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css"/>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
{{-- add new product modal start --}}
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="add_product_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="Pname">Product Name</label>
              <input type="text" name="Pname" class="form-control" placeholder="Prodcut Name" required>
            </div>
            <div class="col-lg">
              <label for="Ctg">Category</label>
              <input type="text" name="Ctg" class="form-control" placeholder="Category" required>
            </div>
          </div>
          <div class="my-2">
            <label for="Vendor">Vendor</label>
            <input type="text" name="Vendor" class="form-control" placeholder="Vendor" required>
          </div>
          <div class="my-2">
            <label for="Amount">Amount</label>
            <input type="tel" name="Amount" class="form-control" placeholder="Amount" required>
          </div>
          <div class="my-2">
            <label for="avatar">Select Avatar</label>
            <input type="file" name="avatar" class="form-control" required>
          </div>
    
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_product_btn" class="btn btn-primary">Add product</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new product modal end --}}

{{-- edit product modal start --}}
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_product_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="prd_id" id="prd_id">
        <input type="hidden" name="prd_avatar" id="prd_avatar">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="Pname">Product Name</label>
              <input type="text" name="Pname" id="Pname" class="form-control" placeholder="Product Name" required>
            </div>
            <div class="col-lg">
              <label for="Ctg">Category</label>
              <input type="text" name="Ctg" id="Ctg" class="form-control" placeholder="Category" required>
            </div>
          </div>
          <div class="my-2">
            <label for="Vendor">Vendor</label>
            <input type="text" name="Vendor" id="Vendor" class="form-control" placeholder="Vendor" required>
          </div>
          <div class="my-2">
            <label for="Amount">Amount</label>
            <input type="tel" name="Amount" id="Amount" class="form-control" placeholder="Amount" required>
          </div>
        
          <div class="my-2">
            <label for="avatar">Select Avatar</label>
            <input type="file" name="avatar" class="form-control">
         </div>
          <div class="mt-2" id="avatar">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_product_btn" class="btn btn-success">Update Product</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit product modal end --}}


  <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-primary d-flex justify-content-between align-items-center">
            <h3 class="text-light">CDF Center</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addProductModal"><i
                class="bi-plus-circle me-2"></i>Add New product</button>
          </div>
          <div class="card-body" id="show_all_Products">
            <h1 class="text-center text-secondary my-5">Loading...</h1>
          </div>
        </div>
      </div>
    </div>
  </div>   
<script
  src="https://code.jquery.com/jquery-3.6.3.min.js"
  integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
 integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
  crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // fetch all product
    fetchAllProducts();
    function fetchAllProducts(){
      $.ajax({
        url:'{{route("fetchAll")}}',
        method:'get',
        success :function(res) {
       $("#show_all_Products").html(res);
       $("table").DataTable({
         order:[0,'desc']
       })
        } 
      })
    }
    // delete product ajax request
     $(document).on('click', '.deleteIcon' , function(e){
       e.preventDefault();
       let id = $(this).attr('id');
       Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
   $.ajax({
     url:'{{ route("delete") }}',
     method:'post',
     data:{
       id:id,
       _token:'{{ csrf_token() }}'
     },
     success: function(res){
       Swal.fire(
         'Deleted!',
         'Product Deleted Successfuly!',
         'success'
       )
       fetchAllProducts();
     }
   
   });
  }
});
     });

    // update product ajax request
    $('#edit_product_form').submit(function(e){
      e.preventDefault();
      const fd = new FormData(this);
      $("#edit_product_btn").text('updating....');
      $.ajax({
        url:'{{route("update")}}',
        method: 'post',
        data: fd,
        cache:false,
        processData:false,
        contentType:false,
        success : function(res){
          if(res.status == 200){
                Swal.fire(
                  'Updated!',
                  'Product updated successfuly!',
                  'success'
                )
                fetchAllProducts();
              } 
              $("#edit_product_btn").text("update Product");
              $("#edit_product_form")[0].reset();
              $("#editProductModal").modal('hide')
        }
      })
    })

    
     // edit product ajax request
     $(document).on('click' , '.editIcon' , function(e){
        e.preventDefault();
        let id=$(this).attr('id');
       $.ajax({
         url:'{{route("edit")}}',
         method:'get',
         data:{
           id:id,
           _token: '{{ csrf_token()}}'
         },
         success:function(res) {
           $("#Pname").val(res.product_name);
           $("#Ctg").val(res.category);
           $("#Vendor").val(res.vendor);
           $("#Amount").val(res.amount);
           $("#avatar").html(`<img src="storage/images/${res.avatar}" width="100"
           class="img-fluid img-thumbnail">`);
           $("#prd_id").val(res.id);
           $("#prd_avatar").val(res.avatar);
         }
       });
      });
    // add new product ajax request
    $("#add_product_form").submit(function(e){
        e.preventDefault();
        const fd= new FormData(this);
        $("#add_product_btn").text('Adding...');
        $.ajax({
            url: "{{route('store')}}",
            method: 'post',
            data: fd,
            cache:false,
            processData:false,
            contentType:false,
            success : function(res){
              if(res.status == 200){
                Swal.fire(
                  'Added!',
                  'Product Added successfuly!',
                  'success'
                )
                fetchAllProducts();
              }
              $("#add_product_btn").text("Add Product");
              $("#add_product_form")[0].reset();
              $("#addProductModal").modal('hide')
            }
        });

     
      
    });  
  </script>

</body>
</html>