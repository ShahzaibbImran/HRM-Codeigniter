<script language="javascript" type="text/javascript">
    function getXMLHTTP() { //fuction to return the xml http object
        var xmlhttp = false;
        try {
            xmlhttp = new XMLHttpRequest();
        }
        catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (e1) {
                    xmlhttp = false;
                }
            }
        }

        return xmlhttp;
    }

    function check_duplicate_emp_id(val) {
        var base_url = '<?= base_url() ?>';
        var strURL = base_url + "admin/global_controller/check_duplicate_emp_id/" + val;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        var result = req.responseText;
                        if (result) {
                            $("#id_error_msg").append(result);
                            document.getElementById('btn_emp').disabled = true;
                        } else {
                            document.getElementById('btn_emp').disabled = false;
                        }

                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("POST", strURL, true);
            req.send(null);
        }

    }
    ;
    function get_employee_by_designations_id(designation_id) {
        var base_url = '<?= base_url() ?>';
        var strURL = base_url + "admin/global_controller/get_employee_by_designations_id/" + designation_id;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        var result = req.responseText;

                        $("#employee").html("<option value='' >Select Employee...</option>");
                        $("#employee").append(result);

                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("POST", strURL, true);
            req.send(null);
        }

    }
    ;
    function check_current_password(val) {
        var base_url = '<?= base_url() ?>';
        var strURL = base_url + "admin/global_controller/check_current_password/" + val;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        var result = req.responseText;
                        if (result) {
                            $("#id_error_msg").css("display", "block");
                            document.getElementById('sbtn').disabled = true;
                        } else {
                            $("#id_error_msg").css("display", "none");
                            document.getElementById('sbtn').disabled = false;
                        }

                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("POST", strURL, true);
            req.send(null);
        }

    }
    function check_employee_password(val) {

        var base_url = '<?= base_url() ?>';
        var strURL = base_url + "employee/dashboard/check_employee_password/" + val;

        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        var result = req.responseText;
                        if (result) {
                            $("#id_error_msg").css("display", "block");
                            document.getElementById('sbtn').disabled = true;
                        } else {
                            $("#id_error_msg").css("display", "none");
                            document.getElementById('sbtn').disabled = false;
                        }

                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("POST", strURL, true);
            req.send(null);
        }

    }
    ;
    function get_item_name_by_id(stock_sub_category_id) {
        var base_url = '<?= base_url() ?>';
        var strURL = base_url + "admin/global_controller/get_item_name_by_id/" + stock_sub_category_id;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        var result = req.responseText;

                        $("#item_name").html("<option value='' >Select Item Name...</option>");
                        $("#item_name").append(result);

                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("POST", strURL, true);
            req.send(null);
        }

    }
    ;
    function check_advance_amount(str) {

        var amount = $.trim(str);
        var employee_id = $.trim($("#employee_id").val());
        var base_url = '<?= base_url() ?>';
        var strURL = base_url + "admin/global_controller/check_advance_amount/" + amount + "/" + employee_id;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        var result = req.responseText;
                        document.getElementById('username_result').innerHTML = result;
                        var msg = result.trim();
                        if (msg) {
                            document.getElementById('sbtn').disabled = true;
                        } else {
                            document.getElementById('sbtn').disabled = false;
                        }

                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("POST", strURL, true);
            req.send(null);


        }
    }
    function check_available_leave(end_date) {
        var leave_category_id = $.trim($("#leave_category").val());
        var employee_id = $.trim($("#employee_id").val());
        var start_date = $.trim($("#start_date").val());
        var base_url = '<?= base_url() ?>';
        var strURL = base_url + "admin/global_controller/check_available_leave/" + employee_id + "/" + start_date + "/" + end_date + "/" + leave_category_id;

        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        var result = req.responseText;
                        document.getElementById('username_result').innerHTML = result;
                        var msg = result.trim();
                        if (msg) {
                            document.getElementById('sbtn').disabled = true;
                        } else {
                            document.getElementById('sbtn').disabled = false;
                        }

                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("POST", strURL, true);
            req.send(null);


        }
    }


</script>