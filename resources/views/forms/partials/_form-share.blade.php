<div id="share-form" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0065a1;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" style="color: white;">{{ trans('Share Form') }}</h6>
            </div>

            <form id="share-form-via-email" method="post" action="#"
                  autocomplete="off">
                @csrf
                <div class="modal-body">
                    <h6 class="text-semibold">{{ trans('Share via Link') }}</h6>
                    <div class="row mb-20">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="text" class="form-control" id="form-url"
                                       value="{{ route('forms.view', $form->code) }}" readonly>
                                <span class="input-group-btn">
                                    <button id="copy" style="background-color: #0065a1;color: white;"
                                            class="btn  btn-icon btn-xs" type="button" data-popup="tooltip-copy"
                                            title="Copy to Clipboard">{{ trans('Copy') }}</button>
                                </span>
                            </div>
                        </div>
                    </div>

{{--                    <h6 class="text-semibold">{{ trans('Share via Email') }}</h6>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <input type="text" name="emails" class="form-control tags-input"--}}
{{--                                       placeholder="{{ trans('To') }}" required="required">--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="email_subject" class="mb-0"><small--}}
{{--                                        class="text-muted">{{ trans('Subjects') }}</small></label>--}}
{{--                                <input type="text" id="email_subject" name="email_subject" class="form-control"--}}
{{--                                       placeholder="Email Subject" value="{{ $form->title }}" required="required">--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="email_message" class="mb-0"><small--}}
{{--                                        class="text-muted">{{ trans('Messages') }}</small></label>--}}
{{--                                <textarea name="email_message" id="email_message" class="form-control elastic" rows="1"--}}
{{--                                          required="required">{{ trans('invite') }}</textarea>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">{{ trans('Cancel') }}</button>
                    <button type="submit" style="background-color: #0065a1;color: white;" class="btn submit"
                            style="color: white;" data-loading-text="Sending...">{{ trans('Send') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
        <script>
            $(function () {
                $('[data-popup=tooltip-copy]').tooltip({
                    template: '<div class="tooltip"><div class="bg-teal"><div class="tooltip-arrow"></div><div class="tooltip-inner" id="copy-tooltip"></div></div></div>',
                    container: 'body'
                });

                $('#copy').on('click', function (e) {
                    var input = $('#form-url').select();

                    document.execCommand("copy");

                    var tooltip = $('#copy-tooltip');
                    tooltip.text('Shortened URL copied');
                }).on('mouseout', function () {
                    setTimeout(function () {
                        $('#copy-tooltip').text('Copy to Clipboard');
                    }, 3000);
                });

                // $('#copy').on('mouseout', function () {
                //     setTimeout(function () {
                //         $('#copy-tooltip').text('Copy to Clipboard');
                //     }, 3000);
                // });

                $('#share-form-via-email').validate({
                    submitHandler: function (form) {
                        shareForm(form);
                        return false;
                    },
                    'rules': {
                        'emails': {
                            'required': true,
                        },
                        'email_subject': {
                            'required': true,
                            'maxlength': 255,
                            'minlength': 3,
                        },
                        'email_message': {
                            'required': true,
                            'maxlength': 30000,
                            'minWords': 3,
                        }
                    },
                    messages: {
                        emails: {
                            required: 'The email address(es) to send the form link to is required'
                        },
                        email_subject: {
                            required: 'The email subject is required'
                        },
                        email_message: {
                            required: 'The email message is required'
                        }
                    }
                });

                function shareForm(form) {
                    var $form = $(form);

                    submit_button = $form.find('.submit');
                    submit_button.button('loading');

                    $.ajax({
                        url: $form.attr('action'),
                        type: $form.attr('method'),
                        data: $form.serialize(),
                        dataType: 'json'
                    })
                    .done(function (response) {
                        submit_button.button('complete');

                        if (response.success) {
                            $form.closest('#share-form').modal('hide');

                            notify('success', 'The form has been shared with the indicated individuals via email');
                        } else {
                            notify('error', 'Error occurred: ' + response.error);
                        }
                    });
                }
            });
        </script>
@endpush
