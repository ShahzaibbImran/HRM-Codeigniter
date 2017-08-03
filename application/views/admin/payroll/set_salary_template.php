<form id="form" role="form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/payroll/set_salary_details/<?php
if (!empty($salary_template_info->salary_template_id)) {
    echo $salary_template_info->salary_template_id;
}
?>" method="post" class="form-horizontal form-groups-bordered">
    <div class="">
        <div class="row">
            <div class="col-sm-12">    
                <div class="wrap-fpanel">
                    <div class="panel panel-default"><!-- *********     Employee Search Panel ***************** -->
                        <div class="panel-heading">
                            <div class="panel-title">
                                <strong><?= lang('set_salary_template')?></strong>
                            </div>
                        </div>                  
                        <div class="panel-body">
                            <div class="row"><br />
                                <div class="col-sm-12 form-groups-bordered">                                                                                    
                                    <div class="form-group" id="border-none">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('salary_grade')?><span class="required"> *</span></label>
                                        <div class="col-sm-5">
                                            <input type="text" name="salary_grade"  value="<?php
                                            if (!empty($salary_template_info->salary_grade)) {
                                                echo $salary_template_info->salary_grade;
                                            }
                                            ?>"  class="form-control" required="1" placeholder="Enter Salary Grade">
                                        </div>
                                    </div>                            
                                    <div class="form-group" id="border-none">
                                        <label for="field-1" class="col-sm-3 control-label">Basic Salary<span class="required"> *</span></label>
                                        <div class="col-sm-5">
                                            <input type="text" name="basic_salary"  value="<?php
                                            if (!empty($salary_template_info->basic_salary)) {
                                                echo $salary_template_info->basic_salary;
                                            }
                                            ?>"  class="salary form-control" required="1" placeholder="Enter Basic Salary">
                                        </div>
                                    </div>                            
                                    <div class="form-group" id="border-none">
                                        <label for="field-1" class="col-sm-3 control-label">Overtime Rate <small> ( Per Hours)</small></label>
                                        <div class="col-sm-5">
                                            <input type="text" name="overtime_salary"  value="<?php
                                            if (!empty($salary_template_info->overtime_salary)) {
                                                echo $salary_template_info->overtime_salary;
                                            }
                                            ?>"  class="form-control" placeholder="Enter Overtime Rate">
                                        </div>
                                    </div>                                                        
                                </div>
                            </div>
                            <br />
                        </div>
                        </form>            
                    </div>
                </div><!-- ******************** Employee Search Panel Ends ******************** -->
            </div>
            <!-- ******************-- Allowance Panel Start **************************-->
            <div class="col-sm-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong>Allowances</strong>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        $total_salary = 0;
                        if (!empty($salary_allowance_info)):foreach ($salary_allowance_info as $v_allowance_info):
                                ?>
                                <div class="">
                                    <input type="text" style="margin:5px 0px;" name="allowance_label[]" value="<?php echo $v_allowance_info->allowance_label; ?>" class="" >
                                    <input type="text" name="allowance_value[]"  value="<?php echo $v_allowance_info->allowance_value; ?>"  class="salary form-control">
                                    <input type="hidden" name="salary_allowance_id[]"  value="<?php echo $v_allowance_info->salary_allowance_id; ?>"  class="salary form-control">
                                </div>
                                <?php $total_salary+=$v_allowance_info->allowance_value; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="">
                                <label class="control-label" >House Rent Allowance </label>
                                <input type="text" name="house_rent_allowance"  value=""  class="salary form-control">
                            </div>
                            <div class="">
                                <label class="control-label" >Medical Allowance </label>
                                <input type="text" name="medical_allowance"  value=""  class="salary form-control">
                            </div>
                        <?php endif; ?>
                        <div id="add_new">                    
                        </div>
                        <div class="margin">                            
                            <strong><a href="javascript:void(0);" id="add_more" class="addCF "><i class="fa fa-plus"></i>&nbsp;Add More</a></strong>
                        </div>
                    </div>
                </div>
            </div><!-- ********************Allowance End ******************-->

            <!-- ************** Deduction Panel Column  **************-->
            <div class="col-sm-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong>Deductions</strong>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        $total_deduction = 0;
                        if (!empty($salary_deduction_info)):foreach ($salary_deduction_info as $v_deduction_info):
                                ?>
                                <div class="">
                                    <input type="text" style="margin:5px 0px;" name="deduction_label[]" value="<?php echo $v_deduction_info->deduction_label; ?>" class="" >
                                    <input type="text" name="deduction_value[]"  value="<?php echo $v_deduction_info->deduction_value; ?>"  class="deduction form-control">
                                    <input type="hidden" name="salary_deduction_id[]"  value="<?php echo $v_deduction_info->salary_deduction_id; ?>"  class="deduction form-control">
                                </div>
                                <?php $total_deduction+=$v_deduction_info->deduction_value ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="">
                                <label class="control-label" >Provident Fund </label>
                                <input type="text" name="provident_fund"  value=""  class="deduction form-control">
                            </div>
                            <div class="">
                                <label class="control-label" >Tax Deduction </label>
                                <input type="text" name="tax_deduction"  value=""  class="deduction form-control">
                            </div>   
                        <?php endif; ?>
                        <div id="add_new_deduc">                    
                        </div>
                        <div class="margin">                            
                            <strong><a href="javascript:void(0);" id="add_more_deduc" class="addCF "><i class="fa fa-plus"></i>&nbsp;Add More</a></strong>
                        </div>
                    </div>
                </div>                    
            </div><!-- ****************** Deduction End  *******************-->
            <!-- ************** Total Salary Details Start  **************-->        
        </div>
        <div class="row">            
            <div class="col-md-8 pull-right">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong>Total Salary Details</strong>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered custom-table" >
                            <tr><!-- Sub total -->
                                <th class="col-sm-8 vertical-td"><strong>Gross Salary  :</strong></th>
                                <td class="">
                                    <input type="text" name="" disabled  value="<?php
                                    if (!empty($total_salary) || !empty($salary_template_info->basic_salary)) {
                                        echo $total = $total_salary + $salary_template_info->basic_salary;
                                    }
                                    ?>" id="total"  class="form-control">
                                </td>
                            </tr> <!-- / Sub total -->
                            <tr><!-- Total tax -->
                                <th class="col-sm-8 vertical-td"><strong>Total Deduction :</strong></th>
                                <td class="">
                                    <input type="text" name="" disabled value="<?php
                                    if (!empty($total_deduction)) {
                                        echo $total_deduction;
                                    }
                                    ?>" id="deduc"  class="form-control">
                                </td>
                            </tr><!-- / Total tax -->
                            <tr><!-- Grand Total -->
                                <th class="col-sm-8 vertical-td"><strong>Net Salary  :</strong></th>
                                <td class="">
                                    <input type="text" name="" disabled required  value="<?php
                                    if (!empty($total) || !empty($total_deduction)) {
                                        echo $total - $total_deduction;
                                    }
                                    ?>" id="net_salary"  class="form-control">
                                </td>
                            </tr><!-- Grand Total -->                                               
                        </table><!-- Order Total table list start -->

                    </div>
                </div>                    
            </div><!-- ****************** Total Salary Details End  *******************-->            
            <div class="col-sm-6 margin pull-right">
                <button  type="submit" class="btn btn-primary btn-block">Save</button>
            </div>    
        </div>
    </div>
</form>

<!--    ************************* Hidden Input Data *******************-->
<script type="text/javascript">
    $(document).ready(function() {
        var maxAppend = 0;
        $("#add_more").click(function() {
            if (maxAppend >= 100)
            {
                alert("Maximum 100 File is allowed");
            } else {
                var add_new = $('<div class="row">\n\
    <div class="col-sm-12"><input type="text" name="allowance_label[]" style="margin:5px 0px;" class="" placeholder="Enter Allowances Label" required ></div>\n\
<div class="col-sm-9"><input  type="text" name="allowance_value[]" placeholder="Enter Allowances Value" required  value="<?php
                                           if (!empty($emp_salary->other_deduction)) {
                                               echo $emp_salary->other_deduction;
                                           }
                                    ?>"  class="salary form-control"></div>\n\
<div class="col-sm-3"><strong><a href="javascript:void(0);" class="remCF"><i class="fa fa-times"></i>&nbsp;Remove</a></strong></div></div>');
                maxAppend++;
                $("#add_new").append(add_new);
            }
        });

        $("#add_new").on('click', '.remCF', function() {
            $(this).parent().parent().parent().remove();
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var maxAppend = 0;
        $("#add_more_deduc").click(function() {
            if (maxAppend >= 100)
            {
                alert("Maximum 100 File is allowed");
            } else {
                var add_new = $('<div class="row">\n\
    <div class="col-sm-12"><input type="text" name="deduction_label[]" style="margin:5px 0px;" class="" placeholder="Enter Deductions Label" required></div>\n\
<div class="col-sm-9"><input  type="text" name="deduction_value[]" placeholder="Enter Deductions Value" required  value="<?php
                                           if (!empty($emp_salary->other_deduction)) {
                                               echo $emp_salary->other_deduction;
                                           }
                                    ?>"  class="deduction form-control"></div>\n\
<div class="col-sm-3"><strong><a href="javascript:void(0);" class="remCF_deduc"><i class="fa fa-times"></i>&nbsp;Remove</a></strong></div></div>');
                maxAppend++;
                $("#add_new_deduc").append(add_new);
            }
        });

        $("#add_new_deduc").on('click', '.remCF_deduc', function() {
            $(this).parent().parent().parent().remove();
        });
    });
</script>

<script type="text/javascript">
    $(document).on("change", function() {
        var sum = 0;
        var deduc = 0;
        $(".salary").each(function() {
            sum += +$(this).val();
        });

        $(".deduction").each(function() {
            deduc += +$(this).val();
        });
        var ctc = $("#ctc").val();

        $("#total").val(sum);
        $("#deduc").val(deduc);
        var net_salary = 0;
        net_salary = sum - deduc;
        $("#net_salary").val(net_salary);


    });
</script>