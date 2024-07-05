<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Products Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <div class="container p-3">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <div class="pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                // Initial load of first page
                loadTable(1);

                // Pagination link click handler
                $(document).on('click', '.pagination a', function(e) {
                    e.preventDefault();
                    const page = $(this).attr('href').split('page=')[1];
                    loadTable(page);
                });

                function loadTable(page) {
                    $.ajax({
                        url: "{{ route('api-product') }}",
                        type: "GET",
                        data: { page: page },
                        success: function (response) {
                            var tbody = $("#table tbody");
                            tbody.empty();
                            
                            $.each(response.data, function (index, product) {
                                var row = "<tr>";
                                row += "<td>" + ((page - 1) * 10 + index + 1) + "</td>";
                                row += "<td>" + product.name + "</td>";
                                row += "<td>" + product.price + "</td>";
                                row += "<td>" + product.quantity + "</td>";
                                row += "</tr>";
                                tbody.append(row);
                            });

                            var paginationHtml = '';
                            $.each(response.links, function(index, link) {
                                if (link.url === null) {
                                    paginationHtml += '<span class="page-link">' + link.label + '</span>';
                                } else {
                                    var activeClass = link.active ? 'active' : '';
                                    paginationHtml += '<li class="page-item ' + activeClass + '"><a class="page-link" href="' + link.url + '">' + link.label + '</a></li>';
                                }
                            });
                            $('.pagination').html('<ul class="pagination">' + paginationHtml + '</ul>');
                        },
                        error: function (xhr, error, thrown) {
                            console.error(xhr, error, thrown);
                        },
                    });
                }

                $(document).on('click', '.pagination a', function(e) {
                    e.preventDefault();
                    const page = $(this).attr('href').split('page=')[1];
                    loadTable(page);
                });
            });
        </script>
    </body>
</html>
