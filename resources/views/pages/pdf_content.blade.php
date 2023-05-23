<html>
    {{-- <head>

        <title>Laravel PDF</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    </head> --}}

    <body>

        <div class="card card-custom">


             <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="p-3" style="border-top: 1px solid #ccc;">

                    @foreach($groups as $group)
                    <h6>{{$group}}</h6>
                    <?php
                       // print_r($all_tags);
                    ?>
                        @foreach($all_tags as $param)

                        <?php
                        $tag_modules=get_fields_by_key($param['key'],'variable','variable_templates','app_module_ids');
                        $param['modules']=json_decode($tag_modules);

                        ?>

                        @if($param['modules'] && in_array($module, $param['modules']) && $param['group']==$group)

                       <button type="button" class="btn btn-secondary btn-sm view_data_param add_merge_field" maileclipse-data-toggle="tooltip" data-placement="top" title="Simple Variable" param-key="{{ $param['key'] }}">
                       <i class="fa fa-anchor mr-1" aria-hidden="true"></i>{ {{ $param['key'] }} }
                       </button>

                       @endif


                        @endforeach
         @endforeach
                </div>

              </div>

            <form name="add-pdf-form" id="add-pdf-form" method="post" action="{{url('store-pdf')}}">
                @csrf
            <div class="card-body">
                <div hidden class="form-group col-md-6">
                    <label for=""> Type </label>
                    <input class="form-control" value="{{ $module }}" type="text" name="app_module_id">
                </div>
                <div class="form-grouptinymce">
                    <label class="form" for="">Content</label>
                    <textarea id="kt-tinymce-4" name="template" class="tox-target">

                    </textarea>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <button  type="submit" class="btn btn-primary ">Submit</button>

            </div>
        </form>
        </div>


    </body>
    </html>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script>


var KTTinymce = function () {
    // Private functions
    var demos = function () {
        tinymce.init({
            selector: '#kt-tinymce-4',
            menubar: false,
            toolbar: ['styleselect fontselect fontsizeselect',
                'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify',
                'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code'],
            plugins : 'advlist autolink link image lists charmap print preview code'
        });
    }

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    KTTinymce.init();
});

$('.add_merge_field').on('click', function(e) {
      e.preventDefault();
      tinymce.activeEditor.execCommand('mceInsertContent', false, $(this).text());
    });
</script>
