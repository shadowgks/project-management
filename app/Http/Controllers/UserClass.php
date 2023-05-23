<?php

namespace App\Http\Controllers;

class userClass
{
    public function get_all_tags()
    {
        $all_tags = [
            [
                'name'      => 'first_name',
                'key'       => 'first_name',
                'group'       => 'user',
                'value'       => [
                    'type' => 'simple',
                    'field_name' => 'id',
                    'table' => 'users',

                ],

                // 'templates'       => [
                //                         'welcomeMembervv',
                //                         'welcomeMembervvv'

                //                                              ],
            ],
            [
                'name'      => 'last_name',
                'key'       => 'last_name',
                'group'       => 'user',
                'value'       => [
                    'type' => 'simple',
                    'field_name' => 'id',
                    'table' => 'users',

                ],
                // 'templates'       => [
                //  //   'invoicetemplate',
                //     'welcomeMembervvv'

                //                          ],
            ],
            [
                'name'      => 'company',
                'key'       => 'company',
                'group'       => 'user',
                'value'       => [
                    'type' => 'simple',
                    'field_name' => 'user_id',
                    'table' => 'user_infos',

                ],
                // 'templates'       => [
                //  //   'invoicetemplate',
                //     'welcomeMembervvv'

                //                          ],
            ],

            [
                'name'      => 'status',
                'key'       => 'name',
                'group'       => 'user',
                'value'       => [
                    'type' => 'join',
                    'field_name' => 'status_id',
                    'id_field_name' => 'id',
                    'table' => 'statues',

                ],
                // 'templates'       => [
                //  //   'invoicetemplate',
                //     'welcomeMembervvv'

                //                          ],
            ],

            [
                'name'      => 'company_name',
                'key'       => 'company_name',
                'group'       => 'company',
                'value'       => [
                    'type' => 'global',
                    'key_field_name' => 'key',
                    'value_field_name' => 'value',
                    'table' => 'settings',

                ],
                // 'templates'       => [
                //  //   'invoicetemplate',
                //     'welcomeMembervvv'

                //                          ],
            ],


        ];

        return $all_tags;
    }
}
