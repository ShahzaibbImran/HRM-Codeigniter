$(document).ready(function() {
    $("#general_settings").validate({// start  settings form valiadaion
        rules: {
            name: "required",
            address: "required",
            country_id: "required",
            email: {
                required: true,
                email: true,
            },
            mobile: {
                required: true,
                number: true,
            },
            currency: "required",
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });//end setting form validation

    // Employee form Validation    
    $("#employee-form").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            job_title: "required",
            date_of_birth: "required",
            gender: "required",
            maratial_status: "required",
            father_name: "required",
            nationality: "required",
            present_address: "required",
            city: "required",
            country_id: "required",
            mobile: "required",
            email: "required",
            employment_id: "required",
            designations_id: "required",
            joining_date: "required",
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }

    });
    $("#time_validation").validate({
        rules: {
            reason: "required",                        
            
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }

    });
    $("#attendance-form").validate({
        rules: {
            department_id: "required",
            date: "required",
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }

    });
    $("#form_validation").validate({
        rules: {
            department_name: "required",
            'designations[]': "required",
            employment_type: "required",
            basic_salary: "required",
            stock_category: "required",
            'stock_sub_category[]': "required",
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }

    });
    jQuery.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "Space are not allowed");
    jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    }, "Letters, numbers or underscores only please");
    $("#update_profile").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            user_name: {
                required: true,
                noSpace: true,
                alphanumeric: true
            }
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }

    });
    $("#change_password").validate({
        rules: {
            old_password: "required",
            new_password: "required",
            confirm_password: {
                required: true,
                equalTo: "#new_password",
            }
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }

    });

    // validate Main Form
    $("#form").validate({
        rules: {
            //validate the Genaral settings into School Settings
            'to[]': "required",
            event_name: "required",
            description: "required",
            start_date: "required",
            end_date: "required",
            category: "required",
            designations_id: "required",
            employee_id: "required",
            award_name: "required",
            award_date: "required",
            date: "required",
            department_id: "required",
            payment_date: "required",
            expense_category: "required",
            expense_category_id: "required",
            stock_sub_category_id: "required",
            item_name: "required",
            purchase_date: "required",
            amount: "required",
            flag: "required",
            title: "required",
            short_description: "required",
            long_description: "required",
            mobile: {
                required: true,
                number: true
            },
            year: "required",
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        messages: {
            firstname: "Please enter your firstname",
            lastname: "Please enter your lastname",
            username: {
                required: "Please enter a username",
                minlength: "Your username must consist of at least 2 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            agree: "Please accept our policy"
        }
    });

});