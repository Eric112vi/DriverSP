@extends('layouts.master')

@section('title')
    Falken
@endsection

@section('css')

@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Universal
        @endslot
        @slot('title')
            Falken
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Falken Invoices</h4>
                    <p class="card-title-desc">
                    </p>

                    <table id="table-falken" class="table table-bordered table-hover nowrap w-100">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>No Invoice</th>
                                <th>Tgl Invoice</th>
                                <th>Kode Customer</th>
                                <th>Nama Customer</th>
                                <th>Alamat</th>
                                <th>Kota</th>
                                <th>Sales</th>
                                <th>Total</th>
                                <th>Total Item Qty</th>
                                <th>Notes</th>
                                <th>Uploaded Photo</th>
                                <th>PIC</th>
                                <th>Confirmed at</th>
                                <th>Confirm Notes</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>

                    <!-- Image preview modal -->
                    <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Photo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="" alt="photo" id="imgModalImg" style="max-width:100%; height:auto;" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice detail modal -->
                    <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Invoice Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-12">
                                        <div class="col-12">
                                            <div class="text-center col-12">
                                                <h5 class="mt-3">Invoice Details</h5>
                                            </div>
                                            <div class="row m-3">
                                                <div class="col-6">
                                                    <p><strong>Invoice Number:</strong> <span id="detail-invoice-number"></span></p>
                                                    <p><strong>Invoice Date:</strong> <span id="detail-invoice-date"></span></p>
                                                    <p><strong>Customer Code:</strong> <span id="detail-customer-code"></span></p>
                                                    <p><strong>Customer Name:</strong> <span id="detail-customer-name"></span></p>
                                                    <p><strong>Address:</strong> <span id="detail-customer-address"></span></p>
                                                </div>
                                                <div class="col-6">
                                                    <p><strong>Customer City:</strong> <span id="detail-customer-city"></span></p>
                                                    <p><strong>Salesman Name:</strong> <span id="detail-salesman-name"></span></p>
                                                    <p><strong>Total Price:</strong> <span id="detail-total-price"></span></p>
                                                    <p><strong>Total Quantity:</strong> <span id="detail-total-quantity"></span></p>
                                                    <p><strong>Notes:</strong> <span id="detail-notes"></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mt-3 ms-3">Photos</h5>
                                    <div id="detail-photos" class="d-flex flex-wrap gap-2 ms-3">
                                        
                                    </div>

                                    <h5 class="mt-3 ms-3">Items</h5>
                                    <table class="table table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail-items-body">
                                            <!-- Item rows will be populated here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            function formatCurrency(value) {
                return 'Rp ' + parseFloat(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }

            // Parse the formatted value to get the raw numeric value
            function parseCurrency(value) {
                return parseFloat(value.replace(/[^\d.]/g, ''));
            }
            var table = $('#table-falken').DataTable({
                pageLength: 50,
                bAutoWidth: false,
                pagingType: 'full_numbers',
                processing: true,
                serverSide: true,
                scrollX: true,  
                ajax: {
                    url: "{{ route('falken') }}"
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "invoice_number",
                        name: "invoice_number"
                    },
                    {
                        data: "invoice_date",
                        name: "invoice_date",
                        render: function(data, type, row) {
                            return moment(data).format('DD MMMM YYYY');
                        }
                    },
                    {
                        data: "customer_code",
                        name: "customer_code"
                    },
                    {
                        data: "customer_name",
                        name: "customer_name"
                    },
                    {
                        data: "customer_address",
                        name: "customer_address"
                    },
                    {
                        data: "customer_city",
                        name: "customer_city"
                    },
                    {
                        data: "salesman_name",
                        name: "salesman_name"
                    },
                    {
                        data: "total_price",
                        name: "total_price",
                        render: function(data, type, row) {
                            return formatCurrency(data);
                        }
                    },
                    {
                        data: "total_quantity",
                        name: "total_quantity"
                    },
                    {
                        data: "notes",
                        name: "notes"
                    },
                    {
                        data: "photos",
                        name: "photos",
                        render: function(data, type, row) {
                            // data could be an array of photo objects or a single string URL
                            if (!data) return '<span class="text-muted">-</span>';
                            var photos = Array.isArray(data) ? data : [data];
                            var html = '';
                            photos.slice(0,3).forEach(function(p){
                                var url = '';
                                if (typeof p === 'string') url = p;
                                else if (p.url) url = p.url;
                                else if (p.path) url = p.path;
                                else if (p.photo_url) url = p.photo_url;
                                // prepend with asset root if needed
                                if (url && url.indexOf('http') !== 0) url = window.location.origin + '/' + url.replace(/^\//, '');
                                html += '<a href="#" class="d-inline-block me-1 photo-thumb" data-src="'+url+'">'
                                     + '<img src="'+url+'" style="width:40px;height:40px;object-fit:cover;border-radius:4px;"/>'
                                     + '</a>';
                            });
                            return html;
                        }
                    },
                    {
                        data: "confirm_by",
                        name: "confirm_by"
                    },
                    {
                        data: "confirm_at",
                        name: "confirm_at"
                    },
                    {
                        data: "confirm_notes",
                        name: "confirm_notes"
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-id', data.id);
                },
            });

            // delegated handler for photo thumbnails
            $(document).on('click', '.photo-thumb', function(e){
                e.preventDefault();
                var src = $(this).data('src');
                if (!src) return;
                $('#imgModalImg').attr('src', src);
                $('#imgModal').modal('show');
            });

            $('#table-falken tbody').on('click', 'tr', function () {
                var id = $(this).data('id');
                if (id) {
                   $.ajax({
                        url: "{{ route('invoice.detail') }}",
                        method: 'GET',
                        data: { id: id },
                        success: function(response) {
                            $('#detail-invoice-number').text(response.invoice.invoice_number);
                            $('#detail-invoice-date').text(moment(response.invoice.invoice_date).format('DD MMMM YYYY'));
                            $('#detail-customer-code').text(response.invoice.customer_code);
                            $('#detail-customer-name').text(response.invoice.customer_name);
                            $('#detail-customer-address').text(response.invoice.customer_address);
                            $('#detail-customer-city').text(response.invoice.customer_city);
                            $('#detail-salesman-name').text(response.invoice.salesman_name);
                            $('#detail-total-price').text(formatCurrency(response.invoice.total_price));
                            $('#detail-total-quantity').text(response.invoice.total_quantity);
                            $('#detail-notes').text(response.invoice.notes);

                            // Populate photos
                            $('#detail-photos').empty();
                            if (response.invoice.photos && response.invoice.photos.length > 0) {
                                response.invoice.photos.slice(0,3).forEach(function(p){
                                    var url = '';
                                    url += p.photo_path;
                                    // prepend with asset root if needed
                                    if (url && url.indexOf('http') !== 0) url = window.location.origin + '/' + url.replace(/^\//, '');
                                    var photoHtml = '<img class="hover-zoom" src="'+url+'" style="width:80px;height:80px;object-fit:cover;border-radius:4px;"/>';
                                    $('#detail-photos').append(photoHtml);
                                });
                            } else {
                                $('#detail-photos').append('<span class="text-muted">-</span>');
                            }

                            // Populate items
                            $('#detail-items-body').empty();
                            response.invoice.sales_item.forEach(function(item){
                                var itemHtml = '<tr>'
                                             + '<td>'+item.kode_barang+'</td>'
                                             + '<td>'+item.nama_barang+'</td>'
                                             + '<td>'+item.quantity+'</td>'
                                             + '<td>'+formatCurrency(item.harga_jual)+'</td>'
                                             + '<td>'+formatCurrency(item.total_harga)+'</td>'
                                             + '</tr>';
                                $('#detail-items-body').append(itemHtml);
                            });
                            $('#invoiceModal').modal('show');
                        },
                        error: function(xhr) {
                            alert('Failed to fetch invoice details.');
                        }
                   }) 
                }
            });
            
            $('#invoiceModal').on('hidden.bs.modal', function () {
                // Clear details when modal is closed
                $('#detail-invoice-number').text('');
                $('#detail-invoice-date').text('');
                $('#detail-customer-code').text('');
                $('#detail-customer-name').text('');
                $('#detail-customer-address').text('');
                $('#detail-customer-city').text('');
                $('#detail-salesman-name').text('');
                $('#detail-total-price').text('');
                $('#detail-total-quantity').text('');
                $('#detail-notes').text('');
                $('#detail-photos').empty();
                $('#detail-items-body').empty();
            });
            
        });
    </script>

@endsection
