<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title">Nib</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">Setting</a></li>
                    <li class="breadcrumb-item"><a href="javaScript:void();">Currnecy</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Currency Data Tables</li>
                </ol>
            </div>
            <div class="col-sm-3">
               
            </div>
        </div>
        <!-- End Breadcrumb-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> Material List</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="brand-datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Currency</th>
                                        <th>Usd Rate</th>
                                        <th>Symbol</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($all_brand != '') {
                                        $i = 1;
                                        foreach ($all_brand as $brand) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>
                                                </td>
                                                <td>
                                                    <?php echo $brand->currency ?>
                                                </td>
                                                <td>
                                                    <?php echo $brand->usd_rate ?>
                                                </td>
                                                <td>
                                                    <?php echo $brand->symbol ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    if ($brand->status == '1') {
                                                        echo '<span class="badge badge-success shadow-success m-1">Enable</span>';

                                                    } elseif ($brand->status == '0') {
                                                        echo '<span class="badge badge-danger shadow-danger m-1">Disable</span>';

                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-secondary waves-effect waves-light m-1"
                                                        data-toggle="modal"
                                                        data-target="#defaultsizemodal<?php echo $brand->id ?>"> <i
                                                            class="fa fa-edit"></i> </button>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!-- Modal -->
                                            <div class="modal fade" id="defaultsizemodal<?php echo $brand->id ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><i class="fa fa-star"></i> Update Material
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form id="update_Material<?php echo $brand->id ?>" method="post"
                                                            action="<?php echo base_url(); ?>product/update_currency_data"
                                                            enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="input-1">Currency</label>
                                                                    <input type="text" class="form-control" name="name"
                                                                     value="<?php echo $brand->currency; ?>"
                                                                        placeholder="Enter CUrrency" readonly>
                                                                    <div class="form_error_msg brand_nameError"></div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="input-1">Usd Rate</label>
                                                                    <input type="text" name="usd_rate" class="form-control"
                                                                        value="<?php echo $brand->usd_rate; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="input-1">Symbol</label>
                                                                    <input readonly type="text" name="symbol" class="form-control"
                                                                        value="<?php echo $brand->symbol; ?>">
                                                                </div>
                                                            </div>
                                                            <input type="hidden" value="<?php echo $brand->id; ?>" name="id">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal"><i class="fa fa-times"></i>
                                                                    Close</button>
                                                                <button type="submit" class="btn btn-primary"><i
                                                                        class="fa fa-check-square-o"></i>Update</button>
                                                            </div>
                                                            <div class="success_message"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                $(function () {
                                                    $('#update_Material<?php echo $brand->id ?>').ajaxForm({
                                                        beforeSend: function () {
                                                            $('.form_error_msg').html('');
                                                            $('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Data update!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
                                                        },
                                                        complete: function (response) {
                                                            var temp = JSON.parse(response.responseText);
                                                            if (temp.status == 'success') {
                                                             window.location.reload();
                                                            } 
                                                        }
                                                    });
                                                });

                                            </script>
                                        <?php }
                                    } else {
                                        echo '';
                                    } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Row-->


    </div>
    <!-- End container-fluid-->


    <script type="text/javascript">
        $(function () {
            $('#add_material').ajaxForm({
                beforeSend: function () {
                    $('.form_error_msg').html('');
                    $('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Data add!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
                },
                complete: function (response) {
                    var temp = JSON.parse(response.responseText);
                    if (temp.status == 'success') {
                        $('.success_message').show().html(temp.message);
                        window.location.href = temp.redirect;
                    } else if (temp.status == 'error') {
                        $('.success_message').html('');
                        $.each(temp.errors, function (key, val) {
                            $('.' + key).html(val);
                        })
                    }
                }
            });
        });

    </script>
