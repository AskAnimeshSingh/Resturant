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
                            <h4>Update Terms and Condition</h4>
                        </div>
                        <div class="card-body">
                            <form class="addtermandcondition">
                                <div class="form-group">
                                    <label for="">Heading 1</label>
                                    <input type="text" class="form-control" value="{{ $terms->heading1 }}"
                                        name="heading1" id="" placeholder="General Terms For Buyers">
                                </div>
                                <div class="form-group">
                                    <label for="">Answer 1</label>
                                    <textarea class="form-control" name="answer1" id="summernote" cols="30" rows="15" placeholder="">{!! html_entity_decode($terms->answer1) !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Heading 2</label>
                                    <input type="text" class="form-control" value="{{ $terms->heading2 }}"
                                        name="heading2" id=""
                                        placeholder="Security">
                                </div>
                                <div class="form-group">
                                    <label>Answer 2</label>
                                    <textarea class="form-control" name="answer2" id="summernote1" cols="30" rows="15" placeholder="">{!! html_entity_decode($terms->answer2) !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Heading 3</label>
                                    <input type="text" class="form-control" value="{{ $terms->heading3 }}"
                                        name="heading3" id="" placeholder="Cookie Policy">
                                </div>
                                <div class="form-group">
                                    <label>Answer 3</label>
                                    <textarea class="form-control" name="answer3" id="summernote2" cols="30" rows="10" placeholder="">{!! html_entity_decode($terms->answer3) !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Heading 4</label>
                                    <input type="text" class="form-control" value="{{ $terms->heading3 }}"
                                        name="heading4" id=""
                                        placeholder="Refunds">
                                </div>
                                <div class="form-group">
                                    <label>Answer 4</label>
                                    <textarea class="form-control" name="answer4" id="summernote3" cols="30" rows="15" placeholder="">{!! html_entity_decode($terms->answer3) !!}</textarea>
                                </div>


                                <input type="hidden" value="{{ $terms->id }}" name="id">
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
                height: 250,
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
                height: 150,
                focus: true
            });


        });

        $("body").on("submit", ".addtermandcondition", function(e) {
            e.preventDefault()
            let fd = new FormData(this)
            fd.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('admin.update.term_and_condition') }}",
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
                            window.location.href = "{{ route('admin.view.term_and_condition') }}"
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
