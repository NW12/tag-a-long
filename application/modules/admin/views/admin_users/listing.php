

<div class="page-header">

    <h1>

        Admin Users

        <small>

            <i class="ace-icon fa fa-angle-double-right"></i>

            Manage Admin Users

        </small>

    </h1>

</div><!-- /.page-header -->



<div class="row">

    <div class="col-xs-12">

        <?php

        if (rights(11) == true) {

            ?>

            <div class="col-sm-8"></div>

            <div class="col-sm-4">

                <a href="<?php echo base_url('admin/admin_users/add') ?>"><button type="button" class="btn btn-primary"   style="float: right; margin-right: 15px;">Add New</button></a>

            </div>

            <?php } ?>

        </div>

    </div>



    <div class="row">

        <div class="col-xs-12">



            <?php

            if ($this->session->flashdata('success_message')) {

                echo '<div class="alert alert-success alertMessage">' . $this->session->flashdata('success_message') . '</div>';

            };

            ?>

            <div class="clearfix"></div>

            <!-- Notification -->

            <?php

            if ($this->session->flashdata('error_message')) {

                echo '<div class="alert alert-danger">' . $this->session->flashdata('error_message') . '</div>';

            };

            ?>

            <div class="clearfix"></div>

            <!-- /Notification -->



            <div class="alert" id="formErrorMsg" style="display: none;">

            </div>



            <table id="dynamic-table" class="table table-striped table-bordered table-hover">

                <thead>

                    <tr>

                        <th>User Name</th>

                        <th>Role</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    if (is_array($result) && count($result) > 0) {

                        $i = 1;

                        foreach ($result as $row) {

                            if ($row['is_active'] == 1) {

                                $status = '<span class="label label-sm label-info status_label' . $row['id'] . '">Active</span>';

                            } else {

                                $status = '<span class="label label-sm label-danger status_label' . $row['id'] . '">Inactive</span>';

                            }

                            ?>

                            <tr id="admin_users_<?php echo $row['id']; ?>">

                                <td><?php echo ucwords($row['user_name']); ?></td>

                                <td><?php

                                if ($row['role_id'] == 0)

                                    echo "Super Admin";

                                else if ($row['role_id'] == 1)

                                    echo "Admin";

                                else if ($row['role_id'] == 2)

                                    echo "Editor";

                                ?>

                            </td>

                            <td><?php echo $status; ?></td>

                            <td>



                                <div class="hidden-sm hidden-xs btn-group">

                                    <?php

                                    if ($row['is_active'] == 1) {

                                        echo '<a title="Status" href="javascript:void(0);" class="blue status_button' . $row['id'] . '" onclick=updateStatus("admin_users",' . $row['id'] . ',1)><i class="ace-icon fa fa-play bigger-130"></i></a>';

                                    } else {

                                        echo '<a title="Status" href="javascript:void(0);" class="red status_button' . $row['id'] . '" onclick=updateStatus("admin_users",' . $row['id'] . ',0)><i class="ace-icon fa fa-stop bigger-130"></i></a>';

                                    }

                                    ?>

                                    <?php

                                    if (rights(12) == true) {

                                        ?>

                                        <a title="Edit" class="green" href="<?php echo base_url('admin/admin_users/edit/' . $this->common->encode($row['id'])); ?>">

                                            <i class="ace-icon fa fa-pencil bigger-130"></i>

                                        </a>

                                        <?php } ?>



                                        <?php

                                        if (rights(13) == true) {

                                            ?>

                                            <a onclick="return delete_confirm();" title="Delete" class="red" href="<?php echo base_url('admin/admin_users/delete/' . $this->common->encode($row['id'])) ?>">

                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>

                                            </a>

                                            <?php

                                        }

                                        ?>

                                    </div>



                                    <div class="hidden-md hidden-lg">

                                        <div class="inline pos-rel">

                                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">

                                                <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>

                                            </button>



                                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">



                                                <?php if ($row['is_active'] == 1) { ?>

                                                <li>

                                                    <a href="javascript:void(0);" onclick="updateStatus('admin_users', '<?php echo $row['id']; ?>', 1)" class="tooltip-info status_sm_button<?php echo $row['id']; ?>" data-rel="tooltip" title="View">

                                                        <span class="blue">

                                                            <i class="ace-icon fa fa-play bigger-120"></i>

                                                        </span>

                                                    </a>

                                                </li>



                                                <?php } else { ?>

                                                <li>

                                                    <a href="javascript:void(0);" onclick="updateStatus('admin_users', '<?php echo $row['id']; ?>', 1)" class="tooltip-info status_sm_button<?php echo $row['id']; ?>" data-rel="tooltip" title="View">

                                                        <span class="red">

                                                            <i class="ace-icon fa fa-stop bigger-120"></i>

                                                        </span>

                                                    </a>

                                                </li>

                                                <?php }

                                                ?>



                                                <?php

                                                if (rights(12) == true) {

                                                    ?>

                                                    <li>

                                                        <a  href="<?php echo base_url('admin/admin_users/edit/' . $this->common->encode($row['id'])) ?>" class="tooltip-success" data-rel="tooltip" title="Edit">

                                                            <span class="green">

                                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>

                                                            </span>

                                                        </a>

                                                    </li>

                                                    <?php } ?>



                                                    <?php

                                                    if (rights(13) == true) {

                                                        ?>

                                                        <li>

                                                            <a  href="<?php echo base_url('admin/admin_users/delete/' . $this->common->encode($row['id'])) ?>" class="tooltip-success" data-rel="tooltip" title="Delete" onclick="return delete_confirm();" >

                                                                <span class="red">

                                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>

                                                                </span>

                                                            </a>

                                                        </li>

                                                        <?php

                                                    }

                                                }

                                                ?>

                                            </ul>

                                        </div>

                                    </div>





                                </td>

                            </tr>

                            <?php

                        }

                        ?>



                    </tbody>

                </table>

            </div>

        </div>



        <!-- page specific plugin scripts -->



        <script src="<?php echo base_url('assets/admin/js/jquery.dataTables.min.js') ?>"></script>

        <script src="<?php echo base_url('assets/admin/js/jquery.dataTables.bootstrap.min.js') ?>"></script>

        <script>

        jQuery(function () {

            $('#dynamic-table').dataTable({

                bAutoWidth: false, scrollX: true,

                "aoColumns": [

                {"bSortable": true},

                null, null, null,

                {"bSortable": false}

                ],

                "aaSorting": []



            });





        });

        </script>