<html>

    <head>
        <style>
            header {
               position: fixed;
               top: -60px;
               left: 0px;
               right: 0px;
               height: 50px;
               font-size: 20px !important;

               /** Extra personal styles **/
               /* background-color: #008B8B; */
               /* color: white; */
               text-align: center;
               line-height: 35px;
           }

   </style>
    </head>

    <body>
        <header>
            <?php
            $header_id=get_fields_by_key($app_module_id, 'app_module_id', 'pdf_templates', 'pdf_header_id');
            $header_content=get_fields_by_key($header_id, 'id', 'pdf_headers', 'content');
            echo $header_content;
        ?>
         </header>
    </body>
</html>
