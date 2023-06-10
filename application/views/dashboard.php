<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    

</head>

<body>
    <!-- header start -->
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
               
                <span class="fs-4">Welcome <?php echo $user['name']; ?></span>
            </a>

            <ul class="nav nav-pills">
                <!-- insert modal button -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#insertModal">
                    Insert Sheet
                </button>
                <!-- logout modal button -->
                <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    Logout
                </button>
            </ul>
        </header>
    </div>
    <!-- header end -->

    <!-- logout modal start -->

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Logout</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Are You Sure Want to Logout</h5>
                   

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- logout Modal end -->

    <!-- Insert modal start -->

    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Insert File</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo base_url('dashboard/import');?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="file" class="form-control" name="sheet" required>
                   

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Insert</button>
                </div>

                </form>
                
            </div>
        </div>
    </div>

    <!-- insert Modal end -->

    <!-- Datatable start -->
    <div class="container">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Sr #</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        
    </div>


    <script>
        $('.datatable').DataTable({
            'processing': true,
            'serverSide': true,
            
           ajax:{
            url:'<?php echo base_url('dashboard/show_table');?>',
            type:'post',
           }
        })
    </script>

</body>

</html>