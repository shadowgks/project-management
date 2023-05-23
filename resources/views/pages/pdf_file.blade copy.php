
<html>
    <head>
        <style>

            @page {
                margin: 100px 25px;
            }


        </style>
              <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    </head>
    <body>

        @include('pdf.header')
        @include('pdf.footer')

        <?php
            echo get_pdf_content($data['rel_type'],$data['module_id']);
        ?>


    </body>
</html>
