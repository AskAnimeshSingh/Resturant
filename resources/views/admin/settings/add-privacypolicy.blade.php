@extends('admin.layout.layouts')
@section('extra_css')
    <style>
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header float-right">
                            <h4>Update Privacy Policy</h4>
                        </div>
                        <div class="card-body">
                            <form class="addprivacypolicy">
                                <div class="form-group">
                                    <label for="">Heading 1</label>
                                    <input type="text" class="form-control" value="{{ $privacypolicy->heading1 }}"
                                        name="heading1" id="" placeholder="Who we are">
                                </div>
                                <div class="form-group">
                                    <label for="">Answer 1</label>
                                    <input type="text" class="form-control" value="{{ $privacypolicy->answer1 }}"
                                        name="answer1" id=""
                                        placeholder="Our website address is https://xcrino.com.">
                                </div>
                                <div class="form-group">
                                    <label>Heading 2</label>
                                    <input type="text" class="form-control" value="{{ $privacypolicy->heading2 }}"
                                        name="heading2" id=""
                                        placeholder="What personal data we collect and why we collect it">
                                </div>
                                <div class="form-group">
                                    <label>Answer 2</label>
                                    <textarea class="form-control" name="answer2" id="summernote" cols="30" rows="15" placeholder="">{!! html_entity_decode($privacypolicy->answer2) !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Heading 3</label>
                                    <input type="text" class="form-control" value="{{ $privacypolicy->heading3 }}"
                                        name="heading3" id="" placeholder="Who we share your data with">
                                </div>
                                <div class="form-group">
                                    <label>Answer 3</label>
                                    <textarea class="form-control" name="answer3" id="summernote1" cols="30" rows="10" placeholder="">{!! html_entity_decode($privacypolicy->answer3) !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Heading 4</label>
                                    <input type="text" class="form-control" value="{{ $privacypolicy->heading4 }}"
                                        name="heading4" id=""
                                        placeholder="We collect information about you during the checkout process on our store.">
                                </div>
                                <div class="form-group">
                                    <label>Answer 4</label>
                                    <textarea class="form-control" name="answer4" id="summernote2" cols="30" rows="15" placeholder="">{!! html_entity_decode($privacypolicy->answer4) !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Heading 5</label>
                                    <input type="text" class="form-control" value="{{ $privacypolicy->heading5 }}"
                                        name="heading5" id="" placeholder="Who on our team has access">
                                </div>
                                <div class="form-group">
                                    <label>Answer 5</label>
                                    <textarea class="form-control" name="answer5" id="summernote3" cols="30" rows="10" placeholder="">{!! html_entity_decode($privacypolicy->answer5) !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Heading 6</label>
                                    <input type="text" class="form-control" value="{{ $privacypolicy->heading6 }}"
                                        name="heading6" id="" placeholder="Payments">
                                </div>
                                <div class="form-group">
                                    <label>Answer 6</label>
                                    <textarea class="form-control" name="answer6" id="summernote4" cols="30" rows="10" placeholder="">{!! html_entity_decode($privacypolicy->answer6) !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Heading 7</label>
                                    <input type="text" class="form-control" value="{{ $privacypolicy->heading7 }}"
                                        name="heading7" id="" placeholder="How long we retain your data">
                                </div>
                                <div class="form-group">
                                    <label>Answer 7</label>
                                    <textarea class="form-control" name="answer7" id="summernote5" cols="30" rows="10" placeholder="">{!! html_entity_decode($privacypolicy->answer7) !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Heading 8</label>
                                    <input type="text" class="form-control" value="{{ $privacypolicy->heading8 }}"
                                        name="heading8" id="" placeholder="What rights you have over your data">
                                </div>
                                <div class="form-group">
                                    <label>Answer 8</label>
                                    <textarea class="form-control" name="answer8" id="summernote6" cols="30" rows="10" placeholder="">{!! html_entity_decode($privacypolicy->answer8) !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Heading 9</label>
                                    <input type="text" class="form-control" value="{{ $privacypolicy->heading9 }}"
                                        name="heading9" id="" placeholder="Where we send your data">
                                </div>
                                <div class="form-group">
                                    <label>Answer 9</label>
                                    <textarea class="form-control" name="answer9" id="summernote7" cols="30" rows="10" placeholder="">{!! html_entity_decode($privacypolicy->answer9) !!}</textarea>
                                </div>
                                <input type="hidden" value="{{ $privacypolicy->id }}" name="id">
                                <div class="mt-4 mb-4"><button type="submit"
                                        class="btn btn-primary btn-lg btn-block">Update</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </section>
@section('extra_js')
    <script src="{{ asset('texteditor/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 150,
                focus: true
            });
            $('#summernote1').summernote({
                height: 200,
                focus: true
            });
            $('#summernote2').summernote({
                height: 150,
                focus: true
            });
            $('#summernote3').summernote({
                height: 200,
                focus: true
            });
            $('#summernote4').summernote({
                height: 150,
                focus: true
            });
            $('#summernote5').summernote({
                height: 150,
                focus: true
            });
            $('#summernote6').summernote({
                height: 150,
                focus: true
            });
            $('#summernote7').summernote({
                height: 150,
                focus: true
            });

        });

        $("body").on("submit", ".addprivacypolicy", function(e) {
            e.preventDefault()
            let fd = new FormData(this)
            fd.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('admin.store.privacy_policy') }}",
                type: "POST",
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,

                success: function(result) {
                    if (result.status) {
                        iziToast.success({
                            title: '',
                            message: result.msg,
                            position: 'topRight'
                        });
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.view.privacy_policy') }}"
                        }, 1500);

                    } else {
                        iziToast.error({
                            title: '',
                            message: result.msg,
                            position: 'topRight'
                        });
                    }
                },

                error: function(jqXHR, exception) {
                    console.log('bye');
                    console.log(jqXHR.responseText);
                }
            });
        })
    </script>
@endsection
@endsection
