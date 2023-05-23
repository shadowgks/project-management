<html>
    <head>
        <style>

             footer {
                position: fixed;
                bottom: -60px;
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
        <footer>
            <?php
            $footer_id=get_fields_by_key($data['app_module_id'], 'app_module_id', 'pdf_templates', 'pdf_footer_id');
            $footer_content=get_fields_by_key($footer_id, 'id', 'pdf_footers', 'content');
            echo $footer_content;
        ?>

        </footer>

    </body>
</html>
