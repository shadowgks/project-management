<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InvoiceTemplate extends Component
{
    public $data = [
        'link' => '#',
        'logo' => 'https://preview.keenthemes.com/metronic8/demo1/assets/media/svg/brand-logos/code-lab.svg',
        'code' => '34782',
        'date' => '2022-4-12',
        'due-date' => '2022-5-2',
        'for' => [
            'name' => 'KeenThemes Inc.',
            'address' => '8692 Wild Rose Drive Livonia, MI 48150',
        ],
        'by' => [
            'name' => 'CodeLab Inc.',
            'address' => '9858 South 53rd Ave. Matthews, NC 28104',
        ],
        'items' => [
            [
                'color' => 'danger',
                'description' => 'Creative Design',
                'hours' => 80,
                'rate' => 40,
                'amount' => 3200,
            ],
            [
                'color' => 'success',
                'description' => 'Logo Design',
                'hours' => 120,
                'rate' => 40,
                'amount' => 4800,
            ],
            [
                'color' => 'primary',
                'description' => 'Web Development',
                'hours' => 210,
                'rate' => 60,
                'amount' => 12600,
            ],
        ],
        'subtotal' => 20.60,
        'vat-percentage' => 0,
        'vat' => 0,
        'subtotal-vat' => 20.60,
        'total' => 20.60,
        'approved' => true,
        'paid' => false,
        'paypal' => 'codelabpay@codelab.co',
        'account' => 'Nl24IBAN34553477847370033 AMB NLANBZTC',
        'project-name' => 'SaaS App Quickstarter',
        'completed-by' => 'Mr. Dewonte Paul',
        'time-spent' => 230,
        'rate-hour' => 35,
    ];

    public function render()
    {
        return view('livewire.invoice-template');
    }
}
