<div class="page-header">

    <h1>

        Newsletter

        <small>

            <i class="ace-icon fa fa-angle-double-right"></i>

            Manage Newsletter

        </small>

    </h1>

</div><!-- /.page-header -->



<div class="row">

    <div class="col-xs-12">

        <?php

        // Check rights

        if (rights(30) == true ) {

            ?>

            <div class="col-sm-8"></div>

            <div class="col-sm-4">

                <a href="<?php echo base_url('admin/newsletter/send_newsletter') ?>"><button type="button" class="btn btn-primary"   style="float: right; margin-right: 15px;">Send Newsletter</button></a>

            </div>

            <?php }?>

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

                        <th>Name</th>

                        <th>Phone</th>

                        <th>Email</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    if ($result->num_rows() > 0) {

                        foreach ($result->result() as $row) {

                            ?>

                            <tr id="newsletter_<?php echo $row->id; ?>">

                                <td><?php echo ucwords($row->company_name); ?></td>

                                <td><?php echo $row->phone; ?></td>

                                <td><?php echo $row->email; ?></td>

                                <td>



                                    <?php

                                    // Check rights

                                    if (rights(31) == true ) {

                                        ?>

                                        <a title="Delete" class="red" href="<?php echo base_url('admin/newsletter/delete/' . $this->common->encode($row->id).'/'.$row->type); ?>" onclick="return delete_confirm();">

                                            <i class="ace-icon fa fa-trash-o bigger-130"></i>

                                        </a>

                                        <?php }?>



                                    </td>

                                </tr>

                                <?php

                            }



                        }  ?>

                    </tbody>

                </table>

            </div>

        </div>



        <!-- page specific plugin scripts -->



        <script src="<?php echo base_url('assets/admin/js/jquery.dataTables.min.js') ?>"></script>

        <script src="<?php echo base_url('assets/admin/js/jquery.dataTables.bootstrap.min.js') ?>"></script>

        <script>

        jQuery(function(){

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