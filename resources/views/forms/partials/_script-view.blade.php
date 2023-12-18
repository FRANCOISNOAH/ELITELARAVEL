<script>
    $(function() {
        let form = '{{ $form->code }}';
        let fields = {!! json_encode($formatted_fields) !!};
        let template_divs = $('#form-fields').children('.field');

        if (!$.isEmptyObject(fields) && template_divs.length > 0) {
            setUpFormFields(fields, template_divs);
        }

        autosize($('.elastic'));

        $('.styled').uniform({
            radioClass: 'choice'
        });

        // $('.bootstrap-select').selectpicker();
        $('select.select').select2({
            minimumResultsForSearch: Infinity
        });

        $('.pickadate').each(function (index) {
            let $pickadate = $(this);

            $pickadate.pickadate({
                format: 'd mmmm, yyyy',
                formatSubmit: 'yyyy-mm-dd',
                hiddenName: true,
                selectMonths: true,
                today: '',
                selectYears: 90,
                editable: true,
                onClose: function() {
                    $('.datepicker').focus();
                }
            });

            let picker_date = $pickadate.pickadate('picker');
            $pickadate.on('click', function(event) {
                if (picker_date.get('open')) {
                    picker_date.close();
                } else {
                    picker_date.open();
                }
                event.stopPropagation();
            });
        });

        $('#user-form').validate({
            submitHandler: function (form) {
                saveResponse(form, function () {
                    let $panel = $(form).closest('.panel-body');
                    let response = '{{ trans('form_submitted_reponse') }}.';
                    let paragraph = $('p').addClass('content-group').text(response);
                    let button1 =  "<a class='btn btn-primary' href='javascript:window.location.reload()'>@lang('send_another_response')</a>";
                    $panel.empty();
                    $panel.append(paragraph);
                    $panel.append(button1);
                    $panel.append(button2);

                }, function (error_message) {
                    notify('error', 'Error occured: ' + error_message);
                });
                return false;
            }
        });


        $('.pickatime').each(function (index) {
            let $pickatime = $(this);

            $pickatime.pickatime({
                editable: true,
                formatSubmit: 'HH:i',
                hiddenName: true
            });

            let picker_time = $pickatime.pickatime('picker');
            $pickatime.on('click', function(event) {
                if (picker_time.get('open')) {
                    picker_time.close();
                } else {
                    picker_time.open();
                }
                event.stopPropagation();
            });
        });

        function setUpFormFields(fields, template_divs) {
            template_divs.each(function (index) {
                let field_id = $(this).data('id');
                let field_attribute = $(this).data('attribute');
                let field_attribute_type = $(this).data('attributeType');

                let field_data = fields[field_attribute];
                let template = $(this).find('.template');

                let label = template.find('label.field-label');
                let id = field_attribute + '.' + field_id;

                label.attr('for', id);
                label.find('span.question').text(field_data['question']);

                if (field_data['required']) {
                    label.append(' <span class="text-danger required">*</span>');
                }

                if (field_attribute_type === 'single') {
                    let template_input = template.find('input');
                    let input = (template_input.length) ? template_input : template.find('textarea');

                    input.attr({
                        id: id,
                        name: field_attribute
                    });

                    if (field_data['required']) {
                        input.prop('required', true);
                        input.attr('required', 'required');
                    }
                } else {
                    let options_div = template.find('.options');
                    if (options_div.hasClass('button')) {
                        let type = options_div.hasClass('checkboxes') ? 'checkbox' : 'radio';
                        let sample_button = options_div.find('div.' + type).clone();
                        options_div.empty();

                        if (field_data['options'] !== null) {
                            let field_options = field_data['options'];
                            for (let i = 0; i < field_options.length; i++) {
                                let button = sample_button.clone();
                                let button_field_name = 'input[type='+ type +']';
                                let input = button.find(button_field_name);
                                let name = (type === 'checkbox') ? field_attribute + '[]' : field_attribute;

                                input.attr({
                                    name: name,
                                    value: field_options[i]
                                });

                                if (i === 0 && field_data['required']) {
                                    input.prop('required', true);
                                    input.attr('required', 'required');
                                }

                                button.find('span.option').text(field_options[i]);
                                options_div.append(button);
                            }
                        }
                    } else if (options_div.hasClass('select')) {
                        let select = options_div.find('select.select');
                        select.attr({
                            id: id,
                            name: field_attribute
                        });

                        if (field_data['required']) {
                            select.prop('required', true);
                            select.attr('required', 'required');
                        }

                        if (field_data['options'] !== null) {
                            let field_options = field_data['options'];
                            let option = '<option value="">Choose an Option</option>'
                            for (let i = 0; i < field_options.length; i++) {
                                option += '<option value="' + field_options[i] + '">' + field_options[i] + '</option>';
                            }
                            select.append(option);
                        }
                    } else if (options_div.hasClass('scale')) { // Linear scale
                        let input = options_div.find('.input-group');
                        let field_options = field_data['options'];
                        let min = field_options["min"];
                        let max = field_options["max"];

                        if (min["label"] === null && max["label"] === null) {
                            input.removeClass('input-group').addClass('no-label');
                        }

                        if (min["label"] !== null) {
                            let option_span = $('<span class="input-group-addon option-label"></span>');
                            option_span.text(min["label"]);
                            input.prepend(option_span);
                        }

                        let min_value = Number(min["value"]);
                        let max_value = Number(max["value"]);
                        let input_range = $('<input type="range" class="form-control slider" name="' + field_attribute + '" id="' + id + '" min="' + min_value + '" max="' + max_value + '" step="1">');
                        if (field_data['required']) {
                            input_range.prop('required', true);
                            input_range.attr('required', 'required');
                        }
                        input.append(input_range);
                        let values = [];

                        for (let i = min_value; i <= max_value; i++) {
                            values.push(i);
                        }

                        input_range.ionRangeSlider({
                            min: min_value,
                            max: max_value,
                            // grid: true,
                            step: 1,
                            prefix: 'Rating: ',
                            keyboard: true,
                            values: values,
                        });

                        if (max["label"] !== null) {
                            let option_span = $('<span class="input-group-addon option-label"></span>');
                            option_span.text(max["label"]);
                            input.append(option_span);
                        }
                    }
                }
            });
        }

        function saveResponse(form, successCallback, failedCallback) {
            let $form = $(form);

            submit_button = $form.find('#submit');
            submit_button.button('loading');
            myToken = new URLSearchParams(window.location.search).get('token');
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: $form.serialize(),
                headers: {
                    "Authorization": myToken
                },
                dataType: 'json'
            })
            .done(function (response) {
                submit_button.button('complete');

                if (response.success) {
                    successCallback();
                } else {
                    failedCallback(response.error);
                }
            });
        }
    });



    function notify(type, message) {
        noty({
            width: 200,
            text: message,
            type: type,
            dismissQueue: true,
            timeout: 6000,
            layout: 'top',
            buttons: false
        });
    }
</script>
