<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Skills Test Nicholas</title>

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha256-916EbMg70RQy9LHiGkXzG8hSg9EdNy97GazNG/aiY1w=" crossorigin="anonymous" >
        <!--Import jQuery before export.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>


    <!--Data Table-->
    <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

<!--Export table button CSS-->

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>     

       
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
        
                    <h3>Products
                        <button type="button" class="btn btn-xs btn-primary float-right add">Add Product</button>
                    </h3>
                    <hr>
        
                    <table id="products" class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Date Submitted</th>
                                <th>Total Value</th>
                                <th>Total Value All</th>
                                <th width="70">Action</th>
                            </tr>
                        </thead>
        
                    </table>
        
        
                    <!--  -->
                    <div class="modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <form class="form" action="" method="">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">New Product</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id">
        
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control input-sm">
                                        </div>
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="text" name="quantity" class="form-control input-sm">
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" class="form-control input-sm">
                                        </div>
                                        <div class="form-group">
                                            <label for="dob">Date Submitted</label>
                                            <input type="datetime-local" name="dob" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-save">Save</button>
                                        <button type="button" class="btn btn-primary btn-update">Update</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--  -->
        
        
        
                </div>
            </div>
        </div>
      <script type="text/javascript">
        
        jQuery(document).ready(function($){
    $.noConflict();
    var token = '{{ csrf_token() }}';
    var modal = $('.modal')
    var form = $('.form')
    var btnAdd = $('.add'),
        btnSave = $('.btn-save'),
        btnUpdate = $('.btn-update');
        
    var table = $('#products').DataTable({
        
            ajax: '/',
            serverSide: true,
            processing: true,
            aaSorting:[[0,"desc"]],
            paging: true, // Enable pagination
            pageLength: 10, // Set the number of records per page
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'quantity', name: 'quantity'},
                {data: 'price', name: 'price'},
                {data: 'date_submitted', name: 'date_submitted'},
                {data: 'total_value', name: 'total_value'},
                {data: 'sum_total',name: 'sum_total'},
                {data: 'action', name: 'action'},
            ],
            
        });

    btnAdd.click(function(){
        modal.modal()
        form.trigger('reset')
        modal.find('.modal-title').text('Add New')
        btnSave.show();
        btnUpdate.hide()
    })

    btnSave.click(function(e){
        e.preventDefault();
        var data = form.serialize()
        console.log(data)
        $.ajax({
           type: "POST",
            url: "/save",
            data: data+'&_token='+token,
            success: function (data) {
                if (data.success) {
                    table.draw();
                    form.trigger("reset");
                    modal.modal('hide');
                }
                else {
                   alert('Save Fail');
               }
            }
         }); //end ajax
    })

   
    $(document).on('click','.btn-edit',function(){
        btnSave.hide();
        btnUpdate.show();

        
        modal.find('.modal-title').text('Update Record')
        modal.find('.modal-footer button[type="submit"]').text('Update')

        var rowData =  table.row($(this).parents('tr')).data()
        
        form.find('input[name="id"]').val(rowData.id)
        form.find('input[name="name"]').val(rowData.name)
        form.find('input[name="price"]').val(rowData.price)
        form.find('input[name="quantity"]').val(rowData.quantity)
        form.find('input[name="dob"]').val(rowData.date_submitted)
        console.log(rowData);

        modal.modal()
    })

    btnUpdate.click(function(){
        if(!confirm("Are you sure?")) return;
        var formData = form.serialize()+'&_method=PUT&_token='+token
        var updateId = form.find('input[name="id"]').val()
        $.ajax({
            type: "PUT",
            url: "/save/" + updateId,
            data: formData,
            success: function (data) {
                if (data.success) {
                    table.draw();
                    modal.modal('hide');
                }
            }
         }); //end ajax
    })
        

    $(document).on('click','.btn-delete',function(){
        if(!confirm("Are you sure?")) return;

        var rowid = $(this).data('rowid')
        var el = $(this)
        if(!rowid) return;

        
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: "/delete/" + rowid,
            data: {_method: 'delete',_token:token},
            success: function (data) {
                if (data.success) {
                    table.row(el.parents('tr'))
                        .remove()
                        .draw();
                }
            }
         }); //end ajax
    })
})
      </script>
    </body>
</html>
