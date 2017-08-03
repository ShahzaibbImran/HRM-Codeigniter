<footer class="col-sm-12 footer">      
    <div class="container">
        <div class="row">
            <p class="text-center margin">
                Designed and Developed by <a href="#" style="color: #fff" target="_blank">Aimviz</a>
            </p>

        </div>
    </div>
</footer>           

<script src="<?php echo base_url() ?>asset/js/select2.js"></script>

<script src="<?php echo base_url(); ?>asset/js/custom-validation.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>asset/js/jquery.validate.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>asset/js/bootstrap.min.js" type="text/javascript"></script>    
<script src="<?php echo base_url() ?>asset/js/jasny-bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>asset/js/bootstrap-datepicker.js" ></script> 
<script src="<?php echo base_url() ?>asset/js/timepicker.js" ></script>  

<!-- Data Table -->
<script src="<?php echo base_url(); ?>asset/js/plugins/metisMenu/metisMenu.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>asset/js/plugins/dataTables/jquery.dataTables.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>asset/js/plugins/dataTables/dataTables.bootstrap.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $("[id^=dataTables-example]").dataTable({
            "bSort": false,
        });
        $(".select_2_to").select2({
            placeholder: "To:",
            tags: true,
            allowClear: true,
            tokenSeparators: [',', ' ']
        });
    });
</script>


</body>
</html>