<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container">
        <div class="mt-5 shadow">
            <div class="card">
                <div class="card-header m-1">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">ADD</button>
                </div>
                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>Column 1</th>
                                <th>Column 2</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Row 1 Data 1</td>
                                <td>Row 1 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('welcome.form.data.saved') }}" method="post" enctype="multipart/form-data"
                    id="add_newStudent_form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- -------------------------------------------from-body------------------------------------------- --}}
                        @csrf
                        <div class="row g-3">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="First name"
                                    aria-label="First name" name="fname">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Last name"
                                    aria-label="Last name" name="lname">
                            </div>
                            <div>
                                <input type="email" class="form-control" id="inputAddress" placeholder="E-mail"
                                    name="mail">
                            </div>
                            <div class="input-group">
                                <input type="file" class="form-control" id="inputGroupFile04"
                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="avatar">
                            </div>
                        </div>
                        {{-- -------------------------------------------from-body------------------------------------------- --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="close_stu_btn">Close</button>
                        <button type="submit" class="btn btn-primary" id="add_stu_btn">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#myTable').DataTable();
            $('#add_newStudent_form').submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $('#add_stu_btn').text('Adding . . .');
                $('#close_stu_btn').text('Stop');

                $.ajax({
                    url: "{{ route('welcome.form.data.saved') }}",
                    method: "POST",
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            swal("Success!", "Student added successfully.", "success");
                            $('#add_newStudent_form')[0].reset();
                            $('#exampleModal').modal('hide');
                            $('#add_stu_btn').text('Add Student');
                            $('#close_stu_btn').text('Close');
                            $('#add_newStudent_form')[0].reset();
                            $('#exampleModal').modal('hide');
                        } else {
                            swal("Error!", "Failed to add student.", "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        swal("Error!", "Failed to add student: " + error, "error");
                    }
                });
            });
        });
    </script>
</body>

</html>
