<?php

namespace App\Helpers;

use App\Charts\TestChart;
use Illuminate\Support\Str;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class ChartHelper
{
    public static function render_chart($labels, $data, $name, $type = 'line')
    {
        $chart = new TestChart;
        $chart->labels($labels);
        $chart->dataset($name, $type, $data);
        return $chart;

        // return (new ColumnChartModel())
        //     ->setTitle($name)
        //     ->addColumn('Food', 100, '#f6ad55')
        //     ->addColumn('Shopping', 200, '#fc8181')
        //     ->addColumn('Travel', 300, '#90cdf4');

        // LivewireCharts::columnChartModel()
        //     ->setTitle($name)
        //     ->withOnColumnClickEventName('onColumnClick')
        //     ->setLegendVisibility(false)
        //     //->setOpacity(0.25)
        //     ->setColors(['#b01a1b', '#d41b2c', '#ec3c3b', '#f66665'])
        //     ->setColumnWidth(90)
        //     ->withGrid();
    }
}
