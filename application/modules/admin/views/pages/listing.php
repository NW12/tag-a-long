<div class="page-header">

    <h1>

        CMS Pages

        <small>

            <i class="ace-icon fa fa-angle-double-right"></i>

            Manage CMS Pages

        </small>

    </h1>

</div><!-- /.page-header -->



<div class="row">

    <div class="col-xs-12">

        <?php

        // Check rights

        if (rights(29) == true) {

            ?>

            <div class="col-sm-8"></div>

            <div class="col-sm-4">

                <a href="<?php echo base_url('admin/pages/add') ?>"><button type="button" class="btn btn-primary"   style="float: right; margin-right: 15px;">Add New</button></a>

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

                        <th>Page Name</th>

                        <th class="hidden-480">Page URL</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    if ($result->num_rows() > 0) {

                        foreach ($result->result() as $row) {

                            if ($row->status == 1) {

                                $status = '<span class="label label-sm label-info status_label' . $row->id . '">Active</span>';

                            } else {

                                $status = '<span class="label label-sm label-danger status_label' . $row->id . '">Inactive</span>';

                            }

                            ?>

                            <tr id="pages_<?php echo $row->id; ?>">

                                <td><?php echo ucwords($row->title); ?></td>

                                <td  class="hidden-480"><a target="_blank" href="<?php echo base_url('pages/' . $row->slug); ?>"><?php echo base_url('pages/' . $row->slug); ?></a></td>

                                <td><?php echo $status; ?></td>

                                <td>



                                    <div class="hidden-sm hidden-xs btn-group">

                                        <?php

                                        if ($row->status == 1) {

                                            echo '<a title="Status" href="javascript:void(0);" class="blue status_button' . $row->id . '" onclick=updateStatus("pages",' . $row->id . ',1)><i class="ace-icon fa fa-play bigger-130"></i></a>';

                                        } else {

                                            echo '<a title="Status" href="javascript:void(0);" class="red status_button' . $row->id . '" onclick=updateStatus("pages",' . $row->id . ',0)><i class="ace-icon fa fa-stop bigger-130"></i></a>';

                                        }

                                        ?>

                                        <?php

                                    // Check rights

                                        if (rights(30) == true) {

                                            ?>

                                            <a title="Edit" class="green" href="<?php echo base_url('admin/pages/edit/' . $this->common->encode($row->id)); ?>">

                                                <i class="ace-icon fa fa-pencil bigger-130"></i>

                                            </a>

                                            <?php

                                        }

                                    // Check rights

                                        if (rights(31) == true) {

                                            ?>

                                            <a title="Delete" class="red" href="<?php echo base_url('admin/pages/delete/' . $this->common->encode($row->id)); ?>" onclick="return delete_confirm();">

                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>

                                            </a>

                                            <?php } ?>



                                        </div>



                                        <div class="hidden-md hidden-lg">

                                            <div class="inline pos-rel">

                                                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">

                                                    <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>

                                                </button>



                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">



                                                    <?php if ($row->status == 1) { ?>

                                                    <li>

                                                        <a href="javascript:void(0);" onclick="updateStatus('pages', '<?php echo $row->id; ?>', 1)" class="tooltip-info status_sm_button<?php echo $row->id; ?>" data-rel="tooltip" title="View">

                                                            <span class="blue">

                                                                <i class="ace-icon fa fa-plus bigger-120"></i>

                                                            </span>

                                                        </a>

                                                    </li>



                                                    <?php } else { ?>

                                                    <li>

                                                        <a href="javascript:void(0);" onclick="updateStatus('pages', '<?php echo $row->id; ?>', 1)" class="tooltip-info status_sm_button<?php echo $row->id; ?>" data-rel="tooltip" title="View">

                                                            <span class="red">

                                                                <i class="ace-icon fa fa-minus bigger-120"></i>

                                                            </span>

                                                        </a>

                                                    </li>

                                                    <?php }

                                                    ?>



                                                    <?php

                                            // Check rights

                                                    if (rights(30) == true) {

                                                        ?>

                                                        <li>

                                                            <a  href="<?php echo base_url('admin/pages/edit/' . $this->common->encode($row->id)) ?>" class="tooltip-success" data-rel="tooltip" title="Edit">

                                                                <span class="green">

                                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>

                                                                </span>

                                                            </a>

                                                        </li>

                                                        <?php

                                                    }

                                            // Check rights

                                                    if (rights(31) == true) {

                                                        ?>

                                                        ?>



                                                        <li>

                                                            <a  href="<?php echo base_url('admin/pages/delete/' . $this->common->encode($row->id)); ?>" onclick="return delete_confirm();" class="tooltip-error" data-rel="tooltip" title="Delete">

                                                                <span class="red">

                                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>

                                                                </span>

                                                            </a>

                                                        </li>

                                                        <?php } ?>

                                                    </ul>

                                                </div>

                                            </div>





                                        </td>

                                    </tr>

                                    <?php

                                }

                                ?>



                                <?php }

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

                        bAutoWidth: false,

                        "aoColumns": [

                        {"bSortable": true},

                        null, null,

                        {"bSortable": false}

                        ],

                        "aaSorting": []



                    });





                });

                </script>